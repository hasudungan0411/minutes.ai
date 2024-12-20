@extends('layouts.user')

@section('title', 'Detail')

@section('contents')
    <!-- tombol kembali -->
    <a href="{{ route('home') }}"
        class="inline-block mt-4 mb-4 px-1 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
        ← Kembali ke Beranda
    </a>

    <div class="col-span-2 mt-5 pl-8">
        <!-- Audio Player -->
        <audio id="audio-player" controls class="w-full">
            <source src="{{ Storage::url($transcript->audio_url) }}" type="audio/wav">
            Your browser does not support the audio element.
        </audio>
    </div>


    <div class="grid grid-cols-1 px-10 bg-purple-100 rounded-lg">
        <div class="grid grid-cols-2 p-5 ">
            <div class="col-span-1">
                <div class="font-bold text-lg pl-5">
                    {{ $transcript->audio_name }} <br>
                </div>
                <div class="pl-5">
                    <small>{{ $transcript->created_at->diffForHumans() }} </small>
                </div>
            </div>
            <div class="col-span-1 flex justify-end">
                <div class="pr-5">
                    <div class="flex items-center justify-center">
                        <div class="relative group">
                            <!-- Tombol Dropdown -->
                            <button id="dropdown-button"
                                class="ml-auto inline-flex justify-right items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128ZM128,72a12,12,0,1,0-12-12A12,12,0,0,0,128,72Zm0,112a12,12,0,1,0,12,12A12,12,0,0,0,128,184Z">
                                    </path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="dropdown-menu"
                                class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-4 space-y-1">
                                <a href="#"
                                    class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md text-left">Download</a>
                                <button
                                    class="w-full block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md text-left"
                                    onclick="openModal()">
                                    Share
                                </button>
                                <a href="#"
                                    class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md text-left">Edit</a>
                                <!-- <a href="#"
               class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md text-left">Ganti
               Tipe</a> -->
                            </div>


                        </div>

                    </div>
                </div>
            </div>
            <div class="col-span-2 mt-2">
                <div class=" pl-5">
                    <p>
                        {{ $transcript->speech_to_text }}
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class=" pl-5">
                    <ul>
                        @if ($transcript->diarization && json_decode($transcript->diarization, true))
                            @foreach (json_decode($transcript->diarization, true) as $diary)
                                <li>{{ $diary['start_time'] }} - {{ $diary['speaker'] }}: {{ $diary['text'] }}</li>
                            @endforeach
                        @else
                            <li>Tidak ada hasil diarization.</li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>
    </div>


    <div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster hidden"
        style="background: rgba(0,0,0,.7);">
        <div
            class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Kirim Email</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <!--Body-->
                <div class="my-5">
                    <input type="text" class="border-2 border-black w-full rounded-full h-12 px-5">
                </div>
                <!--Footer-->
                <div class="flex justify-end pt-2">
                    <button
                        class="focus:outline-none modal-close px-4 bg-gray-400 p-3 rounded-lg text-white hover:bg-gray-300">Batal</button>
                    <button
                        class="focus:outline-none px-4 bg-blue-400 p-3 ml-3 rounded-lg text-white hover:bg-teal-400">Kirim</button>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.querySelector('.main-modal');
        const openModalButtons = document.querySelectorAll('[onclick="openModal()"]');
        const closeModalButtons = document.querySelectorAll('.modal-close');

        // Fungsi untuk membuka modal
        function openModal() {
            modal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            modal.classList.add('hidden');
        }

        // Tambahkan event listener ke tombol "Share" untuk membuka modal
        openModalButtons.forEach(button => {
            button.addEventListener('click', openModal);
        });

        // Tambahkan event listener ke tombol "Cancel", "Kirim", dan "X" untuk menutup modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', closeModal);
        });

        // Menutup modal jika pengguna klik di luar konten modal
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');

        // Fungsi untuk toggle dropdown menu
        dropdownButton.addEventListener('click', function() {
            dropdownMenu.classList.toggle('hidden');
        });

        // Tutup dropdown menu jika klik di luar dropdown
        document.addEventListener('click', function(event) {
            const isClickInside = dropdownButton.contains(event.target) || dropdownMenu.contains(event
                .target);
            if (!isClickInside) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('.main-modal');
    const openModalButtons = document.querySelectorAll('[onclick="openModal()"]');
    const closeModalButtons = document.querySelectorAll('.modal-close');

    // Fungsi untuk membuka modal
    function openModal() {
        modal.classList.remove('hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        modal.classList.add('hidden');
    }

    // Tambahkan event listener ke tombol "Share" untuk membuka modal
    openModalButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });

    // Tambahkan event listener ke tombol "Cancel", "Kirim", dan "X" untuk menutup modal
    closeModalButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });

    // Menutup modal jika pengguna klik di luar konten modal
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Fungsi untuk toggle dropdown menu
    dropdownButton.addEventListener('click', function () {
        dropdownMenu.classList.toggle('hidden');
    });

    // Tutup dropdown menu jika klik di luar dropdown
    document.addEventListener('click', function (event) {
        const isClickInside = dropdownButton.contains(event.target) || dropdownMenu.contains(event.target);
        if (!isClickInside) {
            dropdownMenu.classList.add('hidden');
        }
    });
});

</script>