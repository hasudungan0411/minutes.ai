@extends('layouts.user')

@section('title', 'Home')

@section('contents')
    <div class="w-full p-9 ">
        <!-- Search Bar and Logout Icon -->
        <div class="flex justify-between items-center mb-6">
            <input type="text" placeholder="Search..." class="px-4 py-2 border border-gray-300 rounded-lg w-3/4">
        </div>

        <!-- New Notes Section -->
        <div>
            <h2 class="text-lg font-bold mb-2">CATATAN BARU</h2>
            <div class="flex space-x-4 justify-center">
                <button id="openModalButton" class="flex items-center justify-center p-4 bg-gray-200 rounded-lg w-1/4 hover:bg-blue-200">
                    <span class="mr-2"></span> Pilih File Audio
                </button>
                <button id="openLinkModalButton" class="flex items-center justify-center p-4 bg-gray-200 rounded-lg w-1/4 hover:bg-blue-200">
                    <span class="mr-2">🔗</span> Tautkan Link
                </button>
                <button id="openRecordModalButton" class="flex items-center justify-center p-4 bg-gray-200 rounded-lg w-1/4 hover:bg-blue-200">
                    <span class="mr-2">🎤</span> Record Audio
                </button>
            </div>
        </div>

        <!-- All My Notes Section -->
        <div id="all-my-notes" class="mt-9">
            <h2 class="text-lg font-bold mb-2">SEMUA CATATAN</h2>
            <div id="notes-container" class="space-y-4">
                <!-- Note Item -->
                @if ($transcripts->isEmpty())
                    <p>Belum ada hasil transkripsi</p>
                @else
                    @foreach ($transcripts as $transcript)
                        <div class="flex justify-between items-center p-4 bg-purple-100 rounded-lg cursor-pointer" >
                            <div class="flex items-center space-x-4">
                                <span>👥</span>
                                <div>
                                    <strong>{{ $transcript->title }}</strong> <br>
                                    <small>{{ $transcript->created_at->diffForHumans() }}</small> <br>
                                </div>
                            </div>
                            <a href="{{ route('detail', ['id' => $transcript->id]) }}" class="p-2">⋮</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Modal for File Audio -->
    <div id="fileAudioModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center hidden">
        <div class="bg-white p-9 rounded-lg w-9/ md:w-1/5 lg:w-1/3 relative">
            <button id="closeFileAudioModal" class="absolute top-2 right-2 text-gray-600 text-xl">&times;</button>
            <h3 class="text-lg font-bold mb-4">Pilih File Audio dengan format WAV</h3>
            <form action="{{ route('process.audio') }}" method="POST" enctype="multipart/form-data" id="fileUploadForm" class="space-y-4">
                @csrf
                <input type="file" name="audio" id="audio" class="p-2 border border-gray-300 rounded-lg w-full" accept="audio/*">
                @error('audio')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
                <div class="flex justify-end space-x-4">
                    <button type="button" id="closeModalButton" class="p-2 bg-gray-300 rounded-lg">Cancel</button>
                    <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Link -->
    <div id="linkModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center hidden">
        <div class="bg-white p-9 rounded-lg w-3/4 md:w-3/4 lg:w-1/3 relative">
            <button id="closeLinkModal" class="absolute top-2 right-2 text-gray-600 text-xl">&times;</button>
            <h3 class="text-lg font-bold mb-4">Tautkan Link Drive</h3>
            <form action="{{ route('process.link') }}" method="POST" id="linkForm">
                @csrf
                <input type="url" id="Link" class="p-2 border border-gray-300 rounded-lg w-full" name="Link" placeholder="https://drive.google.com/..." required>
                <div class="flex justify-end mt-4">
                  <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">proses</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Screen -->
    <div id="loadingScreen" class="fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center hidden z-50">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500 border-solid"></div>
            <p class="text-white text-lg mt-4">Sedang memproses...</p>
        </div>
    </div>

    <!-- Modal for Record Audio -->
    <div id="recordModal" class="fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center hidden">
        <div class="bg-white p-9 rounded-lg w-3/4 md:w-1/2 lg:w-1/3 relative">
            <button id="closeRecordModal" class="absolute top-2 right-2 text-gray-600 text-xl">&times;</button>
            <h3 class="text-lg font-bold mb-9 text-center">Silahkan rekam suara anda</h3>
            <canvas id="frequencyCanvas" class="w-full h-24 mb-4"></canvas>
            <div class="flex justify-center mb-6 gap-5">
                <button id="startRecordingButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Mulai Merekam</button>
                <button id="pauseRecordingButton" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hidden">Jeda</button>
                <button id="stopRecordingButton" class="bg-red-500 text-white px-4 py-2 rounded-lg hidden">Berhenti</button>
            </div>
            <audio id="audioPlayback" controls class="w-full hidden mt-9"></audio>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <script src="{{ asset('js/transciption.js') }}"></script>
    <script src="{{ asset('js/recording.js') }}"></script>
    <script src="{{ asset('js/fileaudio.js') }}"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileUploadForm = document.getElementById('fileUploadForm');
        const linkForm = document.getElementById('linkForm');
        const loadingScreen = document.getElementById('loadingScreen');
        const modal = document.getElementById('fileAudioModal');
        const closeButtons = [document.getElementById('closeFileAudioModal'), document.getElementById('closeModalButton')];

        // Saat form di-submit, tampilkan loading screen
        fileUploadForm.addEventListener('submit', function () {
            loadingScreen.classList.remove('hidden');
        });
        linkForm?.addEventListener('submit', function () {
            loadingScreen.classList.remove('hidden');
        });

        // Menutup modal jika tombol "Cancel" atau "×" diklik
        closeButtons.forEach(button => {
            button.addEventListener('click', function () {
                modal.classList.add('hidden');
            });
        });

        // Menampilkan modal untuk debugging
        document.getElementById('openModalButton')?.addEventListener('click', function () {
            modal.classList.remove('hidden');
        });
    });
    </script>


@endsection
