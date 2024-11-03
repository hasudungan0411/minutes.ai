<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Awal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
    @include('sweetalert::alert')


    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Nama Proyek -->
            <h1 class="text-lg font-bold">NOTULAIN AI</h1>
            <!-- Tombol Login dan Register -->
            <div>
                <a href="{{ route('auth.login') }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg mr-2">Login</a>
                <a href="{{ route('auth.register') }}" class="px-4 py-2 bg-gray-200 text-blue-600 rounded-lg">Register</a>
            </div>
        </div>
    </header>

    <!-- Konten Halaman -->
    <main class="flex flex-col items-center justify-center mt-16 text-center">
        <h2 class="text-4xl font-bold mb-4">Selamat Datang di Notulain.AI</h2>
        <p class="text-gray-600 mb-8">Temukan fitur dan layanan yang kami sediakan untuk memenuhi kebutuhan Anda dalam pengelolaan rapat yang lebih efektif.</p>

        <a href="{{ url('login') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg text-lg mb-4">Mulai Sekarang</a>

        <!-- Deskripsi Aplikasi -->
        <section class="max-w-4xl mx-auto p-4">
            <h3 class="text-3xl font-semibold mb-4">Tentang Notulain</h3>
            <p class="text-gray-600 mb-4">Notulain adalah aplikasi yang dirancang untuk menyederhanakan dan meningkatkan produktivitas dalam pertemuan. Dengan fitur canggih seperti transkripsi otomatis, pengenalan pembicara (diarization), dan ringkasan, pengguna dapat dengan mudah merekam dan mengelola catatan rapat tanpa kesulitan.</p>
            <p class="text-gray-600 mb-4">Kami memahami bahwa waktu adalah uang. Dengan Minutes.ai, Anda tidak perlu lagi mencatat setiap detail secara manual. Aplikasi ini secara otomatis mengonversi audio rapat menjadi teks, memungkinkan Anda untuk fokus pada diskusi yang berlangsung. Selain itu, ringkasan yang dihasilkan membantu Anda meninjau poin-poin penting dengan cepat.</p>
            <p class="text-gray-600 mb-4">Baik untuk rapat tim kecil maupun konferensi besar, Minutes.ai memberikan pengalaman yang mulus dan efisien. Bergabunglah dengan kami dan ubah cara Anda melakukan pertemuan hari ini!</p>
        </section>

        <!-- Deskripsi Fitur -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Fitur Transkripsi</h3>
                <p class="text-gray-600">Transkripsi otomatis yang akurat untuk merekam setiap percakapan selama rapat.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Diarization</h3>
                <p class="text-gray-600">Mampu mengenali dan mencatat siapa yang berbicara, sehingga catatan lebih terorganisir.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Ringkasan</h3>
                <p class="text-gray-600">Dapatkan ringkasan dari setiap rapat untuk review yang cepat dan mudah.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Kolaborasi Tim</h3>
                <p class="text-gray-600">Fasilitasi kerja sama yang lebih baik dengan berbagi catatan dan ringkasan dengan tim Anda.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Keamanan Data</h3>
                <p class="text-gray-600">Kami memastikan bahwa semua data Anda aman dan terlindungi dengan enkripsi yang kuat.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-2">Dukungan Multibahasa</h3>
                <p class="text-gray-600">Dapatkan dukungan untuk berbagai bahasa untuk memenuhi kebutuhan pengguna internasional.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4 mt-16">
        <div class="container mx-auto text-center">
            <h4 class="text-lg font-bold mb-2">Kontak Kami</h4>
            <p>Email: support@minutes.ai</p>
            <p>Telepon: (021) 123-4567</p>
            <p>Alamat: Jl. Contoh No. 123, Jakarta, Indonesia</p>
            <p class="mt-4">&copy; 2024 Minutes.ai. All rights reserved.</p>
        </div>
    </footer>


</body>

</html>
