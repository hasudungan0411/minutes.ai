<div>
    <!-- Order your soul. Reduce your wants. - Augustine -->
</div><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen ">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm bg-purple-100">
        <h2 class="text-2xl font-bold mb-4 text-center">Masuk</h2>
        <p class="text-center mb-4">Silahkan login dengan akun yang kamu punya. Belum punya akun? <a href="#" class="text-blue-500">Daftar disini</a>.</p>
        <form>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Submit</button>
        </form>
        <div class="text-center my-4">Or</div>
        <button class="w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-lg flex items-center justify-center hover:bg-gray-100">
            <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png" alt="Google" class="w-5 h-5 mr-2">
            Login dengan Google
        </button>
    </div>
</body>
</html>
