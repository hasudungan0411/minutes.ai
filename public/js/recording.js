// buka Modal
document
    .getElementById("openModalButton")
    .addEventListener("click", function () {
        document.getElementById("fileAudioModal").classList.remove("hidden");
    });

document
    .getElementById("openLinkModalButton")
    .addEventListener("click", function () {
        document.getElementById("linkModal").classList.remove("hidden");
    });

document
    .getElementById("openRecordModalButton")
    .addEventListener("click", function () {
        document.getElementById("recordModal").classList.remove("hidden");
    });

// tutup modal
document
    .getElementById("closeFileAudioModal")
    .addEventListener("click", function () {
        document.getElementById("fileAudioModal").classList.add("hidden");
    });

document
    .getElementById("closeLinkModal")
    .addEventListener("click", function () {
        document.getElementById("linkModal").classList.add("hidden");
    });

document
    .getElementById("closeRecordModal")
    .addEventListener("click", function () {
        document.getElementById("recordModal").classList.add("hidden");
    });

// tutup modal dengan klik dimana aja
window.addEventListener("click", function (event) {
    if (
        event.target.classList.contains("fixed") &&
        event.target.classList.contains("inset-0")
    ) {
        document.getElementById("fileAudioModal").classList.add("hidden");
        document.getElementById("linkModal").classList.add("hidden");
        document.getElementById("recordModal").classList.add("hidden");
    }
});

// bagian record
let mediaRecorder;
let audioChunks = [];
let isPaused = false;
let audioContext;
let analyser;
let dataArray;
let animationId;

// fungsi visualisasi frekuensi
function startFrequencyVisualization(stream) {
    const canvas = document.getElementById("frequencyCanvas");
    const canvasCtx = canvas.getContext("2d");
    const WIDTH = canvas.width;
    const HEIGHT = canvas.height;

    // inisialisasi audioContext and analysernode
    if (!audioContext) {
        audioContext = new (window.AudioContext ||
            window.webkit.AudioContext)();
        analyser = audioContext.createAnalyser();
        analyser.fftSize = 256;
        dataArray = new Uint8Array(analyser.frequencyBinCount);
    }

    // hubungkan stream audio ke analyser
    const source = audioContext.createMediaStreamSource(stream);
    source.connect(analyser);

    function draw() {
        if (!isPaused) {
            animationId = requestAnimationFrame(draw);
            analyser.getByteFrequencyData(dataArray);

            // bersihkan canvas ketika frame baru
            canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

            // gambar frekuensi
            const barWidth = (WIDTH / dataArray.length) * 2.5;
            let barHeight;
            let x = 0;

            for (let i = 0; i < dataArray.length; i++) {
                barHeight = dataArray[i] / 2;
                canvasCtx.fillStyle = "rgb(" + (barHeight + 100) + ",50,50)";
                canvasCtx.fillRect(x, HEIGHT - barHeight, barWidth, barHeight);
                x += barWidth + 1;
            }
        }
    }

    draw(); //mulai visualisasi
}

let stream;

// Event listener mulai rekaman
document
    .getElementById("startRecordingButton")
    .addEventListener("click", async function () {
        audioChunks = [];
        stream = await navigator.mediaDevices.getUserMedia({
            audio: true,
        });
        startFrequencyVisualization(stream); //mulai visualisasi

        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.start();

        mediaRecorder.ondataavailable = function (event) {
            audioChunks.push(event.data);
        };

        mediaRecorder.onstop = function () {
            const audioBlob = new Blob(audioChunks, {
                type: "audio/wav",
            });
            const audioUrl = URL.createObjectURL(audioBlob);
            const audio = document.getElementById("audioPlayback");
            audio.src = audioUrl;
            audio.classList.remove("hidden");
            document
                .getElementById("processRecordAudio")
                .classList.remove("hidden");

            // hentikan visualisasi saat selesai rekam
            cancelAnimationFrame(animationId);
            if (audioContext) {
                audioContext.close();
                audioContext = null;
            }
        };

        // menampilkan stop, pause dan sembunyikan start saat merekam
        document.getElementById("startRecordingButton").classList.add("hidden");
        document
            .getElementById("pauseRecordingButton")
            .classList.remove("hidden");
        document
            .getElementById("stopRecordingButton")
            .classList.remove("hidden");

        // sembunyikan audio ketika mulai rekam lagi
        document.getElementById("audioPlayback").classList.add("hidden");
    });

// untuk pause dan resume
document
    .getElementById("pauseRecordingButton")
    .addEventListener("click", function () {
        if (!isPaused) {
            mediaRecorder.pause();
            cancelAnimationFrame(animationId); // jeda visualisasi
            document.getElementById("pauseRecordingButton").textContent =
                "Resume";
            isPaused = true;
        } else {
            mediaRecorder.resume();
            animationId = requestAnimationFrame(function () {
                startFrequencyVisualization(stream); // lanjutkan visualisasi setelah resume
            });
            document.getElementById("pauseRecordingButton").textContent =
                "Pause";
            isPaused = false;
        }
    });

// stop rekaman dan visualisasi
document
    .getElementById("stopRecordingButton")
    .addEventListener("click", function () {
        mediaRecorder.stop();
        cancelAnimationFrame(animationId); //visualisasi berhenti
        if (audioContext) audioContext.close();

        // Reset untuk rekaman next
        document
            .getElementById("startRecordingButton")
            .classList.remove("hidden");
        document.getElementById("pauseRecordingButton").classList.add("hidden");
        document.getElementById("stopRecordingButton").classList.add("hidden");
        document.getElementById("pauseRecordingButton").textContent = "Pause";
    });

// Process Audio Button
document
    .getElementById("processRecordAudio")
    .addEventListener("click", function () {
        alert("Proses Audio...");
    });

// tutup modal dan reset rekaman
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add("hidden");

    // reset ketika modal ditutup
    audioChunks = [];
    const audio = document.getElementById("audioPlayback");
    audio.src = "";
    audio.classList.add("hidden"); // sembunyikan audio
    document.getElementById("processRecordAudio").classList.add("hidden"); //

    // pastikan visualisasi dan audioContext berhenti
    cancelAnimationFrame(animationId);
    if (audioContext) {
        audioContext.close();
        audioContext = null;
    }

    // Bersihkan canvas visualisasi
    const canvas = document.getElementById("frequencyCanvas");
    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
}

// menutup modal klik dimana aja
document
    .getElementById("closeFileAudioModal")
    .addEventListener("click", function () {
        closeModal("fileAudioModal");
    });

document
    .getElementById("closeLinkModal")
    .addEventListener("click", function () {
        closeModal("linkModal");
    });

document
    .getElementById("closeRecordModal")
    .addEventListener("click", function () {
        closeModal("recordModal");
    });

window.addEventListener("click", function (event) {
    if (
        event.target.classList.contains("fixed") &&
        event.target.classList.contains("inset-0")
    ) {
        closeModal("fileAudioModal");
        closeModal("linkModal");
        closeModal("recordModal");
    }
});
