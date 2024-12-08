<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

        <!-- Sidebar -->
        <div class="flex">
        <div class="w-1/6 bg-purple-100 h-screen p-7">
            <h1 class="text-xl font-bold italic mb-14 text-center">NOTULAIN</h1>
            <nav class="flex flex-col space-y-8">
                <a href="{{ route('admin.beranda') }}" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">
                    User
                </a>
                <a href="{{ route('admin.kelola') }}" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">
                    Model
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Search Bar -->
            <div class="flex justify-between items-center mb-6">
                <input type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded-lg w-3/4">
            </div>

            <!-- List User Section -->
            <div>
                <!-- Title Outside the Box -->
                <h2 class="text-2xl font-bold mb-4">List User</h2>

                <!-- Content Box -->
                <div class="p-6 flex justify-end">
                    <!-- Add User Button -->
                  <!-- Modal Tambah User -->
<div id="modalTambahUser" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-lg font-bold mb-4">Tambah User</h2>
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Nama</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-4">
                <button type="button" id="btnCloseModal" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Simpan
                </button>
            </div>
         </form>
        </div>
      </div>

      <button id="btnTambahUser" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
    Tambah User
     </button>

        </div>
    </form>
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
        @foreach($users as $user)
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
    </div>

    <script>
    // Ambil elemen modal dan tombol
    const modalTambahUser = document.getElementById('modalTambahUser');
    const btnTambahUser = document.getElementById('btnTambahUser');
    const btnCloseModal = document.getElementById('btnCloseModal');

    // Event Listener untuk membuka modal
    btnTambahUser.addEventListener('click', () => {
        modalTambahUser.classList.remove('hidden');
    });

    // Event Listener untuk menutup modal
    btnCloseModal.addEventListener('click', () => {
        modalTambahUser.classList.add('hidden');
    });

    // Close modal jika klik di luar area modal
    window.addEventListener('click', (e) => {
        if (e.target === modalTambahUser) {
            modalTambahUser.classList.add('hidden');
        }
    });
</script>
</body>
</html>