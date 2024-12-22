from flask import Flask, request, jsonify
import whisper
import os

app = Flask(__name__)

# Load Whisper model
model = whisper.load_model("turbo")

# Pastikan folder 'temp' ada
temp_dir = os.path.join(os.getcwd(), 'temp')
if not os.path.exists(temp_dir):
    os.makedirs(temp_dir)

@app.route('/process-audio', methods=['POST'])
def process_audio():
    # Ambil file audio dari request
    if 'audio' not in request.files:
        return jsonify({"error": "No audio file uploaded"}), 400
    
    audio_file = request.files['audio']

    # Menyimpan file sementara
    file_path = os.path.join(temp_dir, audio_file.filename)
    audio_file.save(file_path)
    print(f"File saved to: {file_path}")  # 
    

    # Gunakan Whisper untuk transkripsi
    try:
        result = model.transcribe(file_path)
        print(f"Transcription result: {result}")  # Debugging
        return jsonify({"text": result["text"]})

    except Exception as e:
        print(f"Error during transcription: {e}")  # Debugging
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=9999)
