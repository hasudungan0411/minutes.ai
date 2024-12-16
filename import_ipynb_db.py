import json
import mysql.connector

# Membaca file .ipynb yang diterima
file_path = 'path/to/file.ipynb'  # Ganti dengan lokasi file yang diunduh
with open(file_path, 'r') as f:
    notebook_data = json.load(f)

# Menyaring sel-sel kode dan output
cells = notebook_data['cells']
data = []

for cell in cells:
    if cell['cell_type'] == 'code':
        # Ambil kode dari sel
        code = ''.join(cell['source'])
        
        # Ambil output dari sel, jika ada
        outputs = []
        if 'outputs' in cell:
            for output in cell['outputs']:
                if 'text/plain' in output.data:
                    outputs.append(output.data['text/plain'])
        
        data.append({
            'code': code,
            'outputs': outputs
        })

# Menyambungkan ke database MySQL
db = mysql.connector.connect(
    host="localhost",  # Ganti dengan host database Anda
    user="root",       # Ganti dengan username Anda
    password="password",  # Ganti dengan password database Anda
    database="notulain"  # Ganti dengan nama database Anda
)

cursor = db.cursor()

# Membuat tabel (jika belum ada)
cursor.execute("""
    CREATE TABLE IF NOT EXISTS notebook_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        code TEXT,
        outputs TEXT
    )
""")

# Menyisipkan data ke dalam tabel
for entry in data:
    code = entry['code']
    outputs = ' '.join(entry['outputs'])  # Gabungkan output jika ada beberapa

    cursor.execute("""
        INSERT INTO notebook_data (code, outputs)
        VALUES (%s, %s)
    """, (code, outputs))

# Commit perubahan dan menutup koneksi
db.commit()
cursor.close()
db.close()
