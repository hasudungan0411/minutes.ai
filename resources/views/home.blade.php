<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minutes AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-gray-800 px-5">Minutes AI</div>
            <div>
                <a href="/login" class="text-gray-600 hover:text-blue-500 px-6">Login</a>
            </div>
        </div>
    </nav>

    <!-- Header Sidebar -->
    <header class="bg-violet-400 text-white py-8 px-6 fixed top-0 left-0 h-full z-50 shadow-md flex flex-col items-center space-y-14 w-72 bg-cover bg-center">
        <div class="text-xl font-bold text-gray-100">Minutes AI</div>
        <nav class="flex flex-col space-y-8 text-white font-semibold">
            <a href="#upload-section"
                class="text-center hover:border hover:border-white hover:bg-red-500 hover:shadow-lg px-4 py-2 rounded transition duration-500">Home</a>
            <a href="#how-to-use"
                class="text-center hover:border hover:border-white hover:bg-red-500 hover:shadow-lg px-4 py-2 rounded transition duration-300">How to Use</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="ml-72 py-16 px-8">
        <!-- Upload Audio and Link Form Side by Side -->
        <div class="container mx-auto">
            <div class="flex justify-center space-x-8">
                <!-- Upload Audio File Form -->
                <form action="/transcribe" method="POST" enctype="multipart/form-data" class="max-w-md bg-white p-8 rounded-lg shadow-lg w-1/2">
                    @csrf
                    <div class="mb-4">
                        <label for="audio-file" class="block text-gray-700 mb-2 text-center">Pilih file Audio</label>
                        <input type="file" name="audio-file" id="audio-file" class="w-full p-3 border border-gray-300 rounded">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded font-semibold w-full">Mulai</button>
                </form>

                <!-- Input Link Form -->
                <form action="/transcribe" method="POST" class="max-w-md bg-white p-8 rounded-lg shadow-lg w-1/2">
                    @csrf
                    <div class="mb-4">
                        <label for="audio-link" class="block text-gray-700 mb-2 text-center">Masukkan Link</label>
                        <input type="url" name="audio-link" id="audio-link" class="w-full p-3 border border-gray-300 rounded" placeholder="https://example.com/audio.mp3">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded font-semibold w-full">Mulai</button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
