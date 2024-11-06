<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen py-12">
    @include('sweetalert::alert')

    <div class="bg-purple-200 p-8 rounded-lg shadow-lg w-96 mt-4 mb-4">
        <h2 class="text-2xl font-bold mb-4">Daftar</h2>
        <p class="mb-4">Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-blue-500">Login disini.</a></p>
        <form method="POST" action="{{ route('auth.register.post') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ old('name') }}">
                @error('name')
                <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ old('email') }}">
                @error('email')
                <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1" value="{{ old('password') }}">
                @error('password')
                <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded mt-1">
                @error('password')
                <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Submit</button>
        </form>

        <!-- Menampilkan error atau pesan sukses -->
        <!-- @if ($errors->any())
        <div class="mt-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif -->

        @if (session('success'))
        <div class="mt-4 text-green-600">
            {{ session('success') }}
        </div>
        @endif
    </div>
</body>

</html>