<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbarui Profil</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

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
                    <img src="{{ asset('images/avatar.png') }}" alt="Gambar Default" class="w-10 h-10 rounded-full">
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
                    if (!event.target.matches('.flex.items-center')) {
                        const dropdowns = document.getElementsByClassName("hidden");
                        for (let i = 0; i < dropdowns.length; i++) {
                            dropdowns[i].classList.add('hidden');
                        }
                    }
                }
            </script>
        </div>

        <!-- Main Content -->
        <div class="w-3/5 p-9">
            <h1 class="text-4xl font-bold mb-4">Profile</h1>
            <div class="flex items-center mb-8">
                <!-- Profile Picture Section -->
                <div class="relative group">
                    <img src="{{ asset(Auth::user()->fotoprofil ?: 'images/avatar.png') }}" alt="Foto Profil"
                        class="w-48 h-48 rounded-full border border-gray-300">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="absolute inset-0">
                        @csrf
                        @method('PUT')
                        <input type="file" name="fotoprofil" id="fotoprofil" class="hidden"
                            onchange="this.form.submit()">
                        <label for="fotoprofil"
                            class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center text-white text-sm opacity-0 group-hover:opacity-100 cursor-pointer">
                            Ganti Foto
                        </label>
                    </form>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-xl font-semibold">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                        class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-xl font-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                        class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</body>

</html>
