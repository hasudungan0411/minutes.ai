document.getElementById("processFileAudio").addEventListener("click", async function () {
    const fileInput = document.getElementById("audioFile");
    const file = fileInput.files[0];

    if (!file) {
        alert("Pilih file audio terlebih dahulu.");
        return;
    }

    const formData = new FormData();
    formData.append("audio", file);

    try {
        const response = await fetch("/upload-audio", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const result = await response.json();
        if (response.ok) {
            alert(result.message);
            // Tambahkan transkripsi ke "All My Notes"
            const notesContainer = document.getElementById("notes-container");
            const newNote = document.createElement("div");
            newNote.classList.add("flex", "justify-between", "items-center", "p-4", "bg-purple-100", "rounded-lg");
            newNote.innerHTML = `
                <div class="flex items-center space-x-4">
                    <span>📄</span>
                    <div>
                        <h3>${result.note.title}</h3>
                        <p>${result.note.content.substring(0, 50)}...</p>
                    </div>
                </div>
                <button class="p-2">⋮</button>
            `;
            notesContainer.appendChild(newNote);
        } else {
            alert("Gagal memproses file audio.");
        }
    } catch (error) {
        console.error(error);
        alert("Terjadi kesalahan saat memproses file audio.");
    }
});
