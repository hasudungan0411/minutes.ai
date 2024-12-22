// Misalnya audioChunks sudah terisi setelah perekaman suara
let audioChunks = [];

// Kode perekaman suara (sudah ada di kode Anda sebelumnya)
// Misalnya menggunakan MediaRecorder, dsb.

// Fungsi untuk menangani tombol "Proses"
document.getElementById('processRecordAudio').addEventListener('click', function() {
    // Menyusun audio Blob dari audioChunks
    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
    const formData = new FormData();
    formData.append('audio', audioBlob, 'audio.wav');

    // Mengirimkan audio ke server untuk transkripsi
    fetch('/api/transcribe', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        // Setelah transkripsi selesai, menambahkan hasilnya ke All My Notes
        const transcribedText = data.transcription;
        addNoteToList(transcribedText);
        alert("Transkripsi selesai!");
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Terjadi kesalahan saat memproses audio.");
    });
});

// Fungsi untuk menambahkan catatan ke dalam All My Notes
function addNoteToList(text) {
    const notesContainer = document.getElementById('notes-container');
    const noteItem = document.createElement('div');
    noteItem.classList.add('flex', 'justify-between', 'items-center', 'p-4', 'bg-purple-100', 'rounded-lg');
    
    noteItem.innerHTML = `
        <div class="flex items-center space-x-4">
            <span>🎤</span>
            <div>
                <h3>Transkripsi Audio</h3>
                <p>${text}</p>
            </div>
        </div>
    `;
    notesContainer.prepend(noteItem); // Menambahkan catatan baru di atas
}
