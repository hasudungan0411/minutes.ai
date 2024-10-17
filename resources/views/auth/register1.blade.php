<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-purple-100 p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4">Daftar</h2>
        <p class="mb-4">Sudah punya akun? <a href="#" class="text-blue-500">Login disini.</a></p>
        <form>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama</label>
                <input type="text" id="name" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Submit</button>
        </form>
    </div>
</body>
</html>
