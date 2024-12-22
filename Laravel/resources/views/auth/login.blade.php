<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex items-center justify-center min-h-screen">
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

@if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({
                    title: "{{ session('error') }}",
                    icon: 'error',
                    // confirmButtonText: 'OK'
                    confirmButtonColor: "#3085d6",
                });
            });
        </script>
        @endif

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm bg-purple-200">
        <h2 class="text-2xl font-bold mb-4 text-center">Masuk</h2>
        <p class="text-center mb-4">Silahkan login dengan akun yang kamu punya. Belum punya akun? <a href="{{ route('auth.register') }}" class="text-blue-500">Daftar disini</a>.</p>

        <form method="POST" action="{{ route('auth.login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="text" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}">
                @error('email')
                <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Submit</button>
        </form>

        <div class="text-center my-4">Or</div>
        <a href="{{ route('auth.google') }}" class="w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-lg flex items-center justify-center hover:bg-gray-100">
            <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png" alt="Google" class="w-5 h-5 mr-2">
            Login dengan Google
        </a>
    </div>
</body>

</html>