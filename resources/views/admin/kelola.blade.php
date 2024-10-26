<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Model</title>
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
                <h2 class="text-2xl font-bold mb-2 p-2 ">Kelola Model</h2>

    <!-- Card Section for Speech to Text -->
    <div class="border rounded-lg p-6 mb-4">
        <h3 class="text-xl font-semibold mb-2">Speech to text</h3>
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Model yang digunakan" class="p-2 border border-gray-300 rounded-lg w-full">
            <button class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Detail</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Tambah</button>
        </div>
    </div>

    <!-- Card Section for Diarization -->
    <div class="border rounded-lg p-6 mb-4">
        <h3 class="text-xl font-semibold mb-2">Diarization</h3>
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Model yang digunakan" class="p-2 border border-gray-300 rounded-lg w-full">
            <button class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Detail</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Tambah</button>
        </div>
    </div>

    <!-- Card Section for Summarization -->
    <div class="border rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-2">Summarization</h3>
        <div class="flex items-center space-x-4">
            <input type="text" placeholder="Model yang digunakan" class="p-2 border border-gray-300 rounded-lg w-full">
            <button class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Detail</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Tambah</button>
        </div>
    </div>
</div>
