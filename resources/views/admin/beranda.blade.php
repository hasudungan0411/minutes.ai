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
<body class="bg-white-100">

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-1/6 bg-purple-100 h-screen p-7">
            <h1 class="text-xl font-bold italic mb-14 text-center">NOTULAIN</h1>
            <nav class="flex flex-col space-y-8">
                <a href="{{ route('admin.beranda') }}" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">User</a>
                <a href="{{ route('admin.kelola') }}" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">Model</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="w-4/5 p-9">
            <!-- Search Bar and Logout Icon -->
            <div class="flex justify-between items-center mb-6">
                <input type="text" placeholder="Search..." class="p-2 border border-gray-300 rounded-lg w-full">
            </div>

            <!-- New Notes Section -->
            <div>
                <h2 class="text-2xl font-bold mb-2 p-2">LIST USER</h2>

                <!-- User Grid -->
                <div class="grid grid-cols-3 gap-6">
                    <!-- Loop melalui semua pengguna -->
                    @foreach($users as $user)
                        <div class="border rounded-lg p-6 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out h-auto w-full">
                            <img class="w-16 h-16 rounded-full mr-4" src="https://via.placeholder.com/150" alt="User profile">
                            <div class="text-center">
                                <p class="font-semibold">{{ $user->name }}</p>
                                <p class="text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total Users -->
                <div class="mt-4 text-right font-semibold">
                    Total User: {{ $totalUsers }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>


                