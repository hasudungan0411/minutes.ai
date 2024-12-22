<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100">
    @include('sweetalert::alert')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    title: "{{ session('success') }}",
                    icon: 'success',
                    // confirmButtonText: 'OK'
                    confirmButtonColor: "#3085d6",
                });
            });
        </script>
        @endif

@if ($errors->has('name'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Error',
                text: "{{ $errors->first('name') }}",
                icon: 'error',
                confirmButtonColor: "#3085d6",
            });
        });
    </script>
@endif
@if ($errors->has('email'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Error',
                text: "{{ $errors->first('email') }}",
                icon: 'error',
                confirmButtonColor: "#3085d6",
            });
        });
    </script>
@endif
@if ($errors->has('password'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: 'Error',
                text: "{{ $errors->first('password') }}",
                icon: 'error',
                confirmButtonColor: "#3085d6",
            });
        });
    </script>
@endif

    <div class="flex">
        <div class="w-72 bg-purple-100 h-screen p-7 flex flex-col">
            <h1 class="text-xl font-bold italic mb-14 text-center">NOTULAIN</h1>
            <nav class="flex flex-col space-y-8">
                <a href="{{ route('admin.beranda') }}" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">
                    User
                </a>
                <a href="{{ route('admin.kelola') }}" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">
                    Model
                </a>
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
                <div id="dropdown" class="absolute left-0 bottom-full mb-2 w-48 bg-white border rounded shadow-lg hidden">
                    <a href="{{ url('profile/admin') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profil</a>
                    <form action="{{ url('auth/logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</button>
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
    <main class="flex-grow p-6 bg-gray-100">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div>@yield('contents')</div>
        </div>
    </main>
</div>

    @yield('scripts')

</body>
</html>
