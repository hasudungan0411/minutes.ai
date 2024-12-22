from flask import Flask, request, jsonify
import os
import librosa
import torch
from pyannote.audio import Pipeline
from transformers import WhisperProcessor, WhisperForConditionalGeneration
import whisper
from transformers import AutoTokenizer, AutoModelForSeq2SeqLM, AutoModelForSequenceClassification
import nltk
from nltk.corpus import stopwords

app = Flask(__name__)

# Inisialisasi pipeline untuk speaker diarization
diary_pipeline = Pipeline.from_pretrained(
    "pyannote/speaker-diarization-3.1",
    use_auth_token="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"
)

# Inisialisasi Whisper model untuk diarization
model_name = "openai/whisper-medium"
processor = WhisperProcessor.from_pretrained(model_name)
whisper_diarization_model = WhisperForConditionalGeneration.from_pretrained(model_name)

# Load Whisper model untuk transkripsi umum
whisper_general_model = whisper.load_model("turbo")

# Load tokenizer dan model untuk klasifikasi teks
label_tokenizer = AutoTokenizer.from_pretrained("indobenchmark/indobert-base-p1")
label_model = AutoModelForSequenceClassification.from_pretrained("indobenchmark/indobert-base-p1", num_labels=4)

# Load summarization
summary_tokenizer = AutoTokenizer.from_pretrained("cahya/bert2gpt-indonesian-summarization")
summary_model = AutoModelForSeq2SeqLM.from_pretrained("cahya/bert2gpt-indonesian-summarization")

# Download stopwords
nltk.download('stopwords')
stop_words = set(stopwords.words('indonesian'))

# Pastikan folder sementara ada untuk menyimpan file audio sementara
temp_dir = os.path.join(os.getcwd(), 'temp')
if not os.path.exists(temp_dir):
    os.makedirs(temp_dir)

# Fungsi untuk mengonversi waktu ke format MM.SS
def format_time(seconds):
    minutes = int(seconds // 60)
    seconds = seconds % 60
    return f"{minutes:02d}.{seconds:02.0f}"

# Fungsi untuk transkripsi segmen audio
def transcribe_audio_segment(audio_segment, sample_rate, language="indonesian"):
    inputs = processor(audio_segment, sampling_rate=sample_rate, return_tensors="pt").input_features
    forced_decoder_ids = processor.tokenizer.get_decoder_prompt_ids(language=language, task="transcribe")

    with torch.no_grad():
        predicted_ids = whisper_diarization_model.generate(inputs, forced_decoder_ids=forced_decoder_ids)

    transcription = processor.batch_decode(predicted_ids, skip_special_tokens=True)
    return transcription[0]

# Fungsi untuk preprocessing teks
def preprocess_text(text):
    """Menghapus stopword dari teks."""
    words = text.split()
    filtered_words = [word for word in words if word.lower() not in stop_words]
    return " ".join(filtered_words)

# Fungsi untuk membagi teks menjadi chunk
def chunk_text(text, max_chunk_size=512):
    """Membagi teks menjadi chunk dengan mempertimbangkan panjang maksimum."""
    words = text.split()
    chunks = []
    current_chunk = []
    current_size = 0

    for word in words:
        if current_size + len(word) + 1 > max_chunk_size:
            chunks.append(" ".join(current_chunk))
            current_chunk = []
            current_size = 0
        current_chunk.append(word)
        current_size += len(word) + 1

    if current_chunk:
        chunks.append(" ".join(current_chunk))
    return chunks

# Fungsi untuk ringkasan setiap chunk
def summarize_chunks(chunks):
    """Ringkas setiap chunk menggunakan model summarization."""
    summaries = []
    for chunk in chunks:
        input_ids = summary_tokenizer.encode(chunk, return_tensors='pt', truncation=True, max_length=512)
        summary_ids = summary_model.generate(input_ids,
                                             min_length=20,
                                             max_length=80,
                                             num_beams=10,
                                             repetition_penalty=2.5,
                                             length_penalty=1.0,
                                             early_stopping=True,
                                             no_repeat_ngram_size=2,
                                             use_cache=True,
                                             do_sample=True,
                                             temperature=0.8,
                                             top_k=50,
                                             top_p=0.95)
        summaries.append(summary_tokenizer.decode(summary_ids[0], skip_special_tokens=True))
    return summaries

# Fungsi untuk memprediksi jenis kalimat
def predict(texts):
    """Memprediksi jenis kalimat."""
    inputs = label_tokenizer(texts, return_tensors="pt", truncation=True, padding=True)

    with torch.no_grad():
        outputs = label_model(**inputs)
        logits = outputs.logits
        predicted_labels = torch.argmax(logits, dim=1)

    # Mapping label
    label_map = {0: "Perintah", 1: "Pertanyaan", 2: "Pernyataan", 3: "Deadline"}
    return [label_map[label.item()] for label in predicted_labels]

@app.route('/process-audio', methods=['POST'])
def process_audio():
    # Ambil file audio dari request
    if 'audio' not in request.files:
        return jsonify({"error": "No audio file uploaded"}), 400

    audio_file = request.files['audio']

    # Simpan file sementara
    file_path = os.path.join(temp_dir, audio_file.filename)
    audio_file.save(file_path)

    try:
        # Transkripsi umum menggunakan Whisper turbo
        general_transcription = whisper_general_model.transcribe(file_path)

        # Proses diarization
        diarization = diary_pipeline(file_path)

        # Muat audio menggunakan librosa
        audio, sample_rate = librosa.load(file_path, sr=16000)

        # Hasil akhir untuk menyimpan transkripsi setiap pembicara
        diarization_results = []

        # Iterasi setiap segmen pembicara
        for turn, _, speaker in diarization.itertracks(yield_label=True):
            if (turn.end - turn.start) < 1.0:
                continue

            # Potong audio sesuai waktu speaker
            start_sample = int(turn.start * sample_rate)
            end_sample = int(turn.end * sample_rate)
            segment_audio = audio[start_sample:end_sample]

            # Transkripsi segmen
            transcribed_text = transcribe_audio_segment(segment_audio, sample_rate, language="indonesian")

            # Format waktu dan hasil transkripsi
            start_time = format_time(turn.start)
            diarization_results.append({
                "start_time": start_time,
                "speaker": speaker,
                "text": transcribed_text
            })

        # Hapus file sementara
        os.remove(file_path)

        return jsonify({
            "general_transcription": general_transcription["text"],
            "diarization_results": diarization_results
        })

    except Exception as e:
        # Hapus file sementara jika terjadi error
        if os.path.exists(file_path):
            os.remove(file_path)
        return jsonify({"error": str(e)}), 500


@app.route('/process-text', methods=['POST'])
def process_text():
    try:
        # Mengambil JSON data dari request
        data = request.get_json()

        # Jika data tidak ada, beri respons error
        if not data:
            return jsonify({"error": "Input JSON is empty"}), 400

        # Ambil teks dari data yang diterima
        text_to_process = [item['text'] for item in data]

        # Proses teks
        processed_text = preprocess_text(" ".join(text_to_process))

        # Pisahkan teks menjadi potongan-potongan kecil
        chunks = chunk_text(processed_text, max_chunk_size=512)

        # Ringkas teks yang dipotong
        summaries = summarize_chunks(chunks)

        # Prediksi berdasarkan ringkasan
        predictions = predict(summaries)

        # Buat respons JSON yang lebih terstruktur
        response = {
            "status": "success",  # Status pemrosesan
            "message": "Data processed successfully",
            "metadata": {
                "total_texts": len(data),  # Menampilkan jumlah teks yang diproses
                "total_summaries": len(summaries),  # Menampilkan jumlah ringkasan
                "processing_time_seconds": 0.5  # Waktu pemrosesan (bisa dihitung dengan timing)
            },
            "results": [
                {
                    "summary": summary,
                    "prediction": prediction
                }
                for summary, prediction in zip(summaries, predictions)
            ]
        }

        # Debugging: Print respons sebelum dikirim
        print("Response to send:", response)

        # Kembalikan hasil pemrosesan dalam bentuk JSON
        return jsonify(response), 200

    except Exception as e:
        # Menangani error jika ada kesalahan dan memberikan detail error dalam respons
        print("Error:", str(e))
        return jsonify({"status": "error", "message": str(e)}), 500


if __name__ == '__main__':
    app.run(host="0.0.0.0", port=9999)