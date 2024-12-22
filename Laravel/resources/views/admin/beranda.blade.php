@extends('layouts.app')

@section('title', 'Beranda Admin')

@section('contents')
<div class="flex">
    <!-- Main Content -->
    <div class="flex-1 px-4 py-6">
        <!-- Search Bar -->
        <div class="flex justify-between items-center mb-4">
            <input type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded-lg w-3/4">
        </div>

        <!-- List User Section -->
        <div>
            <!-- Title -->
            <h2 class="text-2xl font-bold mb-4">List User</h2>

            <!-- Add User Button & Modal -->
            <div class="mb-4 flex justify-end">
                <button id="btnTambahUser" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Tambah User
                </button>
            </div>

            <!-- Add User Modal -->
            <div id="modalTambahUser" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h2 class="text-lg font-bold mb-4">Tambah User</h2>
                    <form action="{{ route('admin.user.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block font-semibold mb-1">Nama</label>
                            <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block font-semibold mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ old('email') }}">
                            @error('email')
                                <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block font-semibold mb-1">Password</label>
                            <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg">
                            @error('password')
                                <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block font-semibold mb-1">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded-lg">
                            @error('password_confirmation')
                                <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" id="btnCloseModal" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="mt-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Table -->
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Terakhir Login</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-center {{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}">
                            <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d M Y H:i') : 'Belum Login' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('admin.hapusUser', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md">Hapus User</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Users -->
            <div class="mt-4 text-right">
                <p class="font-semibold">Total User: {{ $totalUsers }}</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnTambahUser = document.getElementById('btnTambahUser');
        const modalTambahUser = document.getElementById('modalTambahUser');
        const btnCloseModal = document.getElementById('btnCloseModal');

        // Buka modal saat tombol Tambah User diklik
        if (btnTambahUser) {
            btnTambahUser.addEventListener('click', () => {
                modalTambahUser.classList.remove('hidden'); // Tampilkan modal
            });
        }

        // Tutup modal saat tombol Batal diklik
        if (btnCloseModal) {
            btnCloseModal.addEventListener('click', () => {
                modalTambahUser.classList.add('hidden'); // Sembunyikan modal
            });
        }

        // Tutup modal jika klik di luar modal
        window.addEventListener('click', (e) => {
            if (e.target === modalTambahUser) {
                modalTambahUser.classList.add('hidden'); // Sembunyikan modal
            }
        });
    });

    // SweetAlert for successful add and delete actions
    @if (session('tambahUserSuccess'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('tambahUserSuccess') }}',
            timer: 3000,
            showConfirmButton: false
        }).then(() => {
            document.getElementById('modalTambahUser').classList.add('hidden'); // Close modal
        });
    @endif

    @if (session('hapusUserSuccess'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('hapusUserSuccess') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>

@endsection
