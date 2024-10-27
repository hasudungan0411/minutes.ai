<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin</title>
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
                <h2 class="text-2xl font-bold mb-2 p-2 ">LIST USER</h2>

           <!-- User Grid -->
        <div class="grid grid-cols-3 gap-6">
            <!-- User email 1 -->
            <div class="border rounded-lg p-6 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out h-auto w-full">
                <img class="w-16 h-16 rounded-full mr-4" src="https://tse1.mm.bing.net/th?id=OIP.H6MYIO-l6cP7Jvukt4Q4egHaE8&pid=Api&P=0&h=180" alt="User profile">
                <div class="text-center">
                    <p class="font-semibold text">Shifa Humaira</p>
                    <p class="text-gray-500">email@gmail.com</p>
                </div>
            </div>
            <!-- User email 2 -->
            <div class="border rounded-lg p-4 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out">
                <img class="w-16 h-16 rounded-full mr-4" src="https://tse1.mm.bing.net/th?id=OIP.H6MYIO-l6cP7Jvukt4Q4egHaE8&pid=Api&P=0&h=180" alt="User profile">
                <div>
                    <p class="font-semibold text-center">Shandy Maiza</p>
                    <p class="text-gray-500">email@gmail.com</p>
                </div>
            </div>
            <!-- User email 3 -->
            <div class="border rounded-lg p-4 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out">
                <img class="w-16 h-16 rounded-full mr-4" src="https://tse1.mm.bing.net/th?id=OIP.H6MYIO-l6cP7Jvukt4Q4egHaE8&pid=Api&P=0&h=180" alt="User profile">
                <div>
                    <p class="font-semibold text-center">Rian Hasudungan</p>
                    <p class="text-gray-500">email@gmail.com</p>
                </div>
            </div>
            <!-- User email 4 -->
            <div class="border rounded-lg p-4 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out h-40">
                <img class="w-16 h-16 rounded-full mr-4" src="https://tse1.mm.bing.net/th?id=OIP.H6MYIO-l6cP7Jvukt4Q4egHaE8&pid=Api&P=0&h=180" alt="User profile">
                <div>
                    <p class="font-semibold text-center">Jeremiah Nelwan</p>
                    <p class="text-gray-500">email@gmail.com</p>
                </div>
            </div>
            <!-- User email 5 -->
            <div class="border rounded-lg p-4 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out">
                <img class="w-16 h-16 rounded-full mr-4" src="https://tse1.mm.bing.net/th?id=OIP.H6MYIO-l6cP7Jvukt4Q4egHaE8&pid=Api&P=0&h=180" alt="User profile">
                <div>
                    <p class="font-semibold text-center">Rendy Wahyu</p>
                    <p class="text-gray-500">email@gmail.com</p>
                </div>
            </div>
            <!-- User email 6 -->
            <div class="border rounded-lg p-4 flex flex-col items-center justify-center text-center space-y-4 hover:shadow-lg focus-within:ring-2 ring-blue-400 transition duration-300 ease-in-out">
                <img class="w-16 h-16 rounded-full mr-4" src="https://tse1.mm.bing.net/th?id=OIP.H6MYIO-l6cP7Jvukt4Q4egHaE8&pid=Api&P=0&h=180" alt="User profile">
                <div>
                    <p class="font-semibold text-center">Harry Christopher</p>
                    <p class="text-gray-500">email@gmail.com</p>
                </div>
            </div>
        </div>
        
        <!-- Total Users -->
        <div class="mt-4 text-right font-semibold">
            Total User: 6
        </div>
    </div>
</body>
</html>


                