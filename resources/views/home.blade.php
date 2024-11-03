<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minutes.AI Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    @include('sweetalert::alert')

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-1/5 bg-purple-100 h-screen p-7 flex flex-col justify-between">
            <h1 class="text-xl font-bold mb-14 text-center">MINUTES.AI</h1>
            <nav class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="p-2 bg-white rounded-lg text-center hover:bg-gray-400">Home</a>
                <a href="#" class="p-2 bg-white rounded-lg text-center">How to Use</a>
                <a href="#" class="p-2 bg-white rounded-lg text-center">Settings</a>
            </nav>

            <div class="mt-auto relative">
                <div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
                    <img src="{{ Auth::user()->fotoprofil ? asset(Auth::user()->fotoprofil) : asset('images/avatar.png') }}" 
                    alt="Gambar Default" class="w-10 h-10 rounded-full">
                    <div class="ml-2">
                        <p class="font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div id="dropdown"
                    class="absolute left-0 bottom-full mb-2 w-48 bg-white border rounded shadow-lg hidden">
                    <a href="{{ url('profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Update
                        Profil</a>
                    <form action="{{ url('auth/logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</button>
                    </form>
                </div>
            </div>

            <script>
                function toggleDropdown() {
                    const dropdown = document.getElementById('dropdown');
                    dropdown.classList.toggle('hidden');
                }

                // Tutup dropdown jika pengguna mengklik di luar
                window.onclick = function(event) {
                    if (!event.target.closest('.relative')) {
                        const dropdown = document.getElementById("dropdown");
                        dropdown.classList.add("hidden");
                    }
                };
            </script>
        </div>

        <!-- Main Content -->
        <div class="w-4/5 p-9">
            <!-- Search Bar and Logout Icon -->
            <div class="flex justify-between items-center mb-6">
                <input type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded-lg w-3/4">
            </div>

            <!-- New Notes Section -->
            <div>
                <h2 class="text-lg font-bold mb-2">NEW NOTES</h2>
                <div class="flex space-x-4">
                    <button id="openModalButton"
                        class="flex items-center justify-center p-4 bg-gray-200 rounded-lg w-1/4 hover:bg-blue-200">
                        <span class="mr-2"></span> Pilih File Audio
                    </button>
                    <button id="openLinkModalButton"
                        class="flex items-center justify-center p-4 bg-gray-200 rounded-lg w-1/4">
                        <span class="mr-2">🔗</span> Tautkan Link
                    </button>
                    <button id="openRecordModalButton"
                        class="flex items-center justify-center p-4 bg-gray-200 rounded-lg w-1/4">
                        <span class="mr-2">🎤</span> Record Audio
                    </button>
                </div>
            </div>

            <!-- All My Notes Section -->
            <div class="mt-9">
                <h2 class="text-lg font-bold mb-2">ALL MY NOTES</h2>
                <div class="space-y-4">
                    <!-- Note Item -->
                    @for ($i = 0; $i < 3; $i++)
                        <div class="flex justify-between items-center p-4 bg-purple-100 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <span>👥</span>
                                <div>
                                    <h3>Judul dari pertemuan</h3>
                                    <p>Hari, 00-Bulan-Tahun | 00 Menit</p>
                                </div>
                            </div>
                            <button class="p-2">⋮</button>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="fileModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-9 rounded-lg w-1/3">
            <h2 class="text-lg font-bold mb-4">Upload File Audio</h2>
            <form id="fileUploadForm" class="space-y-4">
                <input type="file" name="audioFile" class="p-2 border border-gray-300 rounded-lg w-full"
                    accept="audio/*">
                <div class="flex justify-end space-x-4">
                    <button type="button" id="closeModalButton" class="p-2 bg-gray-300 rounded-lg">Cancel</button>
                    <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <div id="linkModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-9 rounded-lg w-1/3">
            <h2 class="text-lg font-bold mb-4">Tautkan Link Audio</h2>
            <form id="linkUploadForm" class="space-y-4">
                <input type="url" name="audioLink" class="p-2 mb-2 border border-gray-300 rounded-lg w-full"
                    placeholder="Masukkan URL audio..." required>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="closeLinkModalButton" class="p-2 bg-gray-300 rounded-lg">Cancel</button>
                    <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div id="recordModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-lg font-bold mb-4">Record Audio</h2>
            <div class="flex justify-center mb-4">
                <button id="startRecordingButton" class="p-2 bg-green-500 text-white rounded-lg mr-4">Start
                    Recording</button>
                <button id="stopRecordingButton" class="p-2 bg-red-500 text-white rounded-lg" disabled>Stop
                    Recording</button>
            </div>
            <audio id="audioPlayback" controls class="w-full mb-4 hidden"></audio>
            <div class="flex justify-end space-x-4">
                <button type="button" id="closeRecordModalButton" class="p-2 bg-gray-300 rounded-lg">Cancel</button>
                <button id="saveRecordingButton" class="p-2 bg-blue-500 text-white rounded-lg" disabled>Save
                    Recording</button>
            </div>
        </div>
    </div>


    <!-- Script untuk Modal -->
    <script>
        // Ambil elemen modal dan tombol
        const modal = document.getElementById('fileModal');
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');

        // Fungsi untuk membuka modal
        openModalButton.onclick = () => {
            modal.classList.remove('hidden');
        };

        // Fungsi untuk menutup modal
        closeModalButton.onclick = () => {
            modal.classList.add('hidden');
        };

        // Mencegah submit default form dan menutup modal
        document.getElementById('fileUploadForm').onsubmit = function(event) {
            event.preventDefault();
            modal.classList.add('hidden');
            alert('File uploaded successfully!');
        };

        const linkModal = document.getElementById('linkModal');
        const openLinkModalButton = document.getElementById('openLinkModalButton');
        const closeLinkModalButton = document.getElementById('closeLinkModalButton');

        openLinkModalButton.onclick = () => {
            linkModal.classList.remove('hidden');
        };

        closeLinkModalButton.onclick = () => {
            linkModal.classList.add('hidden');
        };

        document.getElementById('linkUploadForm').onsubmit = function(event) {
            event.preventDefault();
            linkModal.classList.add('hidden');
            alert('Link submitted successfully!');
        };


        const recordModal = document.getElementById('recordModal');
        const openRecordModalButton = document.getElementById('openRecordModalButton');
        const closeRecordModalButton = document.getElementById('closeRecordModalButton');
        const startRecordingButton = document.getElementById('startRecordingButton');
        const stopRecordingButton = document.getElementById('stopRecordingButton');
        const saveRecordingButton = document.getElementById('saveRecordingButton');
        const audioPlayback = document.getElementById('audioPlayback');

        let mediaRecorder;
        let audioChunks = [];

        openRecordModalButton.onclick = () => {
            recordModal.classList.remove('hidden');
        };

        closeRecordModalButton.onclick = () => {
            recordModal.classList.add('hidden');
            resetRecordingUI();
        };

        // Function to start recording
        startRecordingButton.onclick = async () => {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (event) => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, {
                    type: 'audio/wav'
                });
                const audioUrl = URL.createObjectURL(audioBlob);
                audioPlayback.src = audioUrl;
                audioPlayback.classList.remove('hidden');
                saveRecordingButton.disabled = false;
            };

            mediaRecorder.start();
            startRecordingButton.disabled = true;
            stopRecordingButton.disabled = false;
        };

        // Function to stop recording
        stopRecordingButton.onclick = () => {
            mediaRecorder.stop();
            startRecordingButton.disabled = false;
            stopRecordingButton.disabled = true;
        };

        // Save the recording
        saveRecordingButton.onclick = () => {
            const audioBlob = new Blob(audioChunks, {
                type: 'audio/wav'
            });
            const formData = new FormData();
            formData.append('audioFile', audioBlob, 'recording.wav');

            // Upload the file using Fetch API or similar
            // fetch('/upload-audio', { method: 'POST', body: formData })

            recordModal.classList.add('hidden');
            resetRecordingUI();
        };

        function resetRecordingUI() {
            audioChunks = [];
            audioPlayback.src = '';
            audioPlayback.classList.add('hidden');
            saveRecordingButton.disabled = true;
        }
    </script>

</body>

</html>
