@extends('layout.main')

@section('content')
<div class="grid grid-cols-1 px-10">
    <div class="col-span-1 shadow-lg">
        <div class="grid grid-cols-1 px-20">
            <div class="col-span-1">
                <div class="relative w-full ml-2">
                    <div class="bg-red-300 h-2 w-full rounded-lg"></div>
                    <div class="bg-red-500 h-2 w-1/2 rounded-lg absolute top-0"></div>
                </div>
            </div>
            <div class="col-span-1">
                <div class="flex justify-center w-full pt-5">
                    <span class="text-xs text-gray-700 uppercase font-medium pl-2">
                        02:00/04:00
                    </span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="flex flex-col sm:flex-row justify-center items-center p-5">
                    <div class="flex items-center">
                        <div class="flex space-x-3 p-2">
                            <button class="focus:outline-none">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="19 20 9 12 19 4 19 20"></polygon>
                                    <line x1="5" y1="19" x2="5" y2="5"></line>
                                </svg>
                            </button>
                            <button
                                class="rounded-full w-10 h-10 flex items-center justify-center pl-0.5 ring-1 ring-red-400 focus:outline-none">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </button>
                            <button class="focus:outline-none">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="5 4 15 12 5 20 5 4"></polygon>
                                    <line x1="19" y1="5" x2="19" y2="19"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-1 shadow-lg mt-5">
        <div class="grid grid-cols-2 p-5">
            <div class="col-span-1">
                <div class="font-bold text-lg pl-5">
                    Judul Rangkuman
                    <br>
                    00 - 00 - 0000
                </div>
            </div>
            <div class="col-span-1 flex justify-end">
                <div class="pr-5">
                    <div class="flex items-center justify-center">
                        <div class="relative group">
                            <button id="dropdown-button"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128ZM128,72a12,12,0,1,0-12-12A12,12,0,0,0,128,72Zm0,112a12,12,0,1,0,12,12A12,12,0,0,0,128,184Z">
                                    </path>
                                </svg>
                            </button>
                            <div id="dropdown-menu"
                                class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">
                                <a href="#"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">Download</a>
                                <button
                                    class="w-full text-start block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md"
                                    onclick="openModal()">
                                    Share
                                </button>
                                <a href="#"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">Edit</a>
                                <a href="#"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">Ganti
                                    Tipe</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2 mt-2">
                <p>
                pre-condition itu inisial state nya ya? kondisi awal itu inisial state ya, inisial state awalnya kalau ada pre-condition harus ada post-condition atau final state nya di bawah, ok 
                </p>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Speaker 1
                    <br>
                    <p class="text-sm font-normal">
                        pre-condition itu inisial state nya ya?
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Speaker 2
                    <br>
                    <p class="text-sm font-normal">
                        kondisi awal
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Speaker 1
                    <br>
                    <p class="text-sm font-normal">
                        kondisi awal itu inisial state ya, inisial state awalnya kalau ada pre-condition harus ada post-condition atau final state nya di bawah, ok
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Notulensi
                    <br>
                    <p class="text-sm font-normal">
                        Jika ada pre-condition, maka harus ada post-condition atau final state yang dijelaskan di bawah.
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Deadline
                    <br>
                    <p class="text-sm font-normal">
                        Lorem ipsum dolor sit amet. Aut numquam omnis a quia exercitationem et deleniti aperiam aut
                        architecto sint sit quam nesciunt? Rem magni suscipit
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Tantangan
                    <br>
                    <p class="text-sm font-normal">
                        Lorem ipsum dolor sit amet. Aut numquam omnis a quia exercitationem et deleniti aperiam aut
                        architecto sint sit quam nesciunt? Rem magni suscipit
                    </p>
                </div>
            </div>
            <div class="col-span-2 mt-5">
                <div class="font-bold text-lg pl-5">
                    Kesimpulan
                    <br>
                    <p class="text-sm font-normal">
                        Lorem ipsum dolor sit amet. Aut numquam omnis a quia exercitationem et deleniti aperiam aut
                        architecto sint sit quam nesciunt? Rem magni suscipit
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="main-modal fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center animated fadeIn faster"
    style="background: rgba(0,0,0,.7);">
    <div
        class="border border-teal-500 shadow-lg modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <!--Title-->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Kirim Email</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 18 18">
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