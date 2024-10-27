<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Model</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Quill.js CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Quill.js JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
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
                <h2 class="text-2xl font-bold mb-2 p-2 ">Detail Model</h2>

            <!-- Model Boxes -->
            <div class="space-y-4">
                <!-- First Model Box -->
                <div class="border border-gray-300 rounded-lg p-6 shadow-md">
                    <h3 class="font-bold text-lg">DeepSpeech (Mozilla)</h3>
                    <p class="text-gray-700 mt-2">
                        DeepSpeech adalah model open-source yang dikembangkan oleh Mozilla berdasarkan paper dari Baidu.
                        Ini adalah model end-to-end berbasis Recurrent Neural Network (RNN) dengan arsitektur Long Short-Term Memory (LSTM).
                    </p>
                </div>

                <!-- Second Model Box -->
                <div class="border border-gray-300 rounded-lg p-6 shadow-md">
                    <h3 class="font-bold text-lg">DeepSpeech (Mozilla)</h3>
                    <p class="text-gray-700 mt-2">
                        DeepSpeech adalah model open-source yang dikembangkan oleh Mozilla berdasarkan paper dari Baidu.
                        Ini adalah model end-to-end berbasis Recurrent Neural Network (RNN) dengan arsitektur Long Short-Term Memory (LSTM).
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>