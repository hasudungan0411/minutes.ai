<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    @include('sweetalert::alert')

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-1/5 bg-purple-200 h-screen p-7 flex flex-col justify-between">
            <h1 class="text-xl font-bold mb-14 text-center">Notulain</h1>
            <nav class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" class="p-2 bg-white rounded-lg text-center hover:bg-gray-400">Beranda</a>
                <a href="#" class="p-2 bg-white rounded-lg text-center">Cara Penggunaan</a>
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
                    <a href="{{ url('profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
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

            <main class="flex-grow">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div>@yield('contents')</div>
                </div>
            </main>
    </div>

    @yield('scripts')

</body>
</html>
