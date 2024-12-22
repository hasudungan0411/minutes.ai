from flask import Flask, request, jsonify
import os
import librosa
import torch
from pyannote.audio import Pipeline
from transformers import WhisperProcessor, WhisperForConditionalGeneration
import whisper

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
    
@app.route('/add-model', methods=['POST'])
def add_model():
    if 'model' not in request.files:
        return jsonify({"error": "No model file uploaded"}), 400

    model_file = request.files['model']

    model_dir = os.path.join(os.getcwd(), 'python/model')  
    if not os.path.exists(model_dir):
        os.makedirs(model_dir)

    # Simpan file dengan nama unik
    model_path = os.path.join(model_dir, model_file.filename)
    try:
        model_file.save(model_path)  
        return jsonify({
            "success": True,
            "message": f"Model {model_file.filename} berhasil disimpan.",
            "path": model_path  # Path file dikembalikan
        }), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500


if __name__ == '__main__':
    app.run(host="0.0.0.0", port=9999)
