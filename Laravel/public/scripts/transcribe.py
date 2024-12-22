import sys
import whisper

# Memuat model Whisper
model = whisper.load_model("base")

# File audio dari argumen
audio_file = sys.argv[1]

# Transkripsi
result = model.transcribe(audio_file)
print(result["text"])
