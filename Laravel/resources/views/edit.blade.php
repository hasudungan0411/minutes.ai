@extends('layouts.user')

@section('title', 'Detail')

@section('contents')
<!-- tombol kembali -->
<a href="{{ route('detail', ['id' => $transcript->id]) }}" class="inline-block mt-4 mb-4 px-1 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
    ← Kembali ke Detail
</a>

<div class="grid grid-cols-1 px-0 bg-purple-100 rounded-lg w-full">
    <div class="grid grid-cols-1 gap-4 p-5">
        <form action="{{ route('transcript.update', $transcript->id) }}" method="POST" class="w-full">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="col-span-1">
                <div class="font-bold text-lg mb-2">
                    <input type="text" name="title" id="title" value="{{ $transcript->title }}"
                        class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <small>{{ $transcript->created_at->diffForHumans() }}</small>
                </div>
            </div>

            <!-- Speech-to-Text -->
            <div class="col-span-1 mt-4">
                <textarea name="speech_to_text" class="w-full h-32 p-2 border border-gray-300 rounded-md">{{ $transcript->speech_to_text }}</textarea>
            </div>

            <!-- Diarization -->
            <div class="col-span-1 mt-4">
                @php
                    $diarizationText = '';
                    if ($transcript->diarization && json_decode($transcript->diarization, true)) {
                        foreach (json_decode($transcript->diarization, true) as $diary) {
                            $diarizationText .= $diary['speaker'] . "\n";
                            $diarizationText .= $diary['start_time'] . "\n";
                            $diarizationText .= $diary['text'] . "\n\n";
                        }
                    }
                 @endphp
                <textarea name="diarization" class="w-full h-32 p-2 border border-gray-300 rounded-md">{{ trim($diarizationText) }}</textarea>
            </div>

            <!-- Summarization -->
            <div class="col-span-1 mt-4">
                @php
                    $summarizationText = '';
                    if ($transcript->summarization && json_decode($transcript->summarization, true)) {
                        foreach (json_decode($transcript->summarization, true) as $diary) {
                            $summarizationText .= $diary['prediction'] . "\n";
                            $summarizationText .= $diary['summary'] . "\n\n";
                        }
                    }
                @endphp
                <textarea name="summarization" class="w-full h-32 p-2 border border-gray-300 rounded-md">{{ trim($summarizationText) }}</textarea>
            </div>

            <!-- Tombol Ubah -->
            <div class="col-span-1 text-center mt-5">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Ubah
                </button>
            </div>
        </form>
    </div>
</div>




@endsection
