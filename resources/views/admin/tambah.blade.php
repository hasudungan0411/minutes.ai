<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Model</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white-100">

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-1/6 bg-purple-100 h-screen p-7">
            <h1 class="text-xl font-bold italic mb-14 text-center">NOTULAIN</h1>
            <nav class="flex flex-col space-y-8">
                <a href="#" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400 ">User</a>
                <a href="#" class="bg-white p-4 mb-4 rounded-lg text-center font-bold text-xl hover:bg-gray-400">Model</a>
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
                <h2 class="text-2xl font-bold mb-2 p-2 ">Tambah Model</h2>
                <form>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Pilih file model</label>
                    <input type="file" class="block w-full text-sm text-gray-500 border px-4 py-2 border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Nama model</label>
                    <input type="text" class="border w-full px-4 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Deskripsi model</label>
                    <textarea rows="4" class="border w-full px-4 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>