@extends('layouts.app')

@section('title', 'profile-admin')

@section('contents')

    <!-- Main Content -->
    <div class="w-3/5 p-9">
        <h1 class="text-4xl font-bold mb-4">Profile</h1>

        <form action="{{ route('profile.update.admin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex items-center mb-8">
                <!-- Profile Picture Section -->
                <div class="relative group">
                    <img src="{{ Auth::user()->fotoprofil ? asset(Auth::user()->fotoprofil) : asset('images/avatar.png') }}"
                        alt="Foto Profil" class="w-48 h-48 rounded-full border border-gray-300">
                    <input type="file" name="fotoprofil" id="fotoprofil" class="hidden">
                    <label for="fotoprofil"
                        class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center text-white text-sm opacity-0 group-hover:opacity-100 cursor-pointer">
                        Ganti Foto
                    </label>

                </div>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-xl font-semibold">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                    class="w-full p-2 border border-gray-300 rounded-md">
                @error('name')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-xl font-semibold">Email</label>
                <input type="text" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                    class="w-full p-2 border border-gray-300 rounded-md">
                @error('email')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                Simpan
            </button>
        </form>
    </div>
    </div>
@endsection
