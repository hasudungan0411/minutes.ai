@extends('layouts.app')

@section('title', 'Detail')

@section('contents')
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
@endsection