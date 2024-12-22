@extends('layouts.user')

@section('title', 'Detail')

@section('contents')
<!-- tombol kembali -->
<a href="{{ route('detail', ['id' => $transcript->id]) }}" class="inline-block mt-4 mb-4 px-1 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
    ← Kembali ke Detail
</a>

<div class="grid grid-cols-1 px-10 bg-purple-100 rounded-lg">
    <div class="grid grid-cols-2 p-5">
        <div class="col-span-1">
            <div class="font-bold text-lg pl-5">
                {{ $transcript->audio_name }} <br>
            </div>
            <div class="pl-5">
                <small>{{ $transcript->created_at->diffForHumans() }} </small>
            </div>
        </div>

        <div class="col-span-2 mt-2">
            <div class=" pl-5">
                <p>
                {{ $transcript->speech_to_text }} 
                </p>
            </div>
            </div>

        <div class="col-span-2 mt-5">
            <div class="pl-5">
                <ul>
                    @if ($transcript->diarization && json_decode($transcript->diarization, true))
                        @foreach (json_decode($transcript->diarization, true) as $diary)
                            <li>{{ $diary['start_time'] }} - {{ $diary['speaker'] }} <br> {{ $diary['text'] }}</li>
                        @endforeach
                    @else
                        <li>Tidak ada hasil diarization.</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-span-2 mt-2">
            <div class="pl-5">
                <!-- Form untuk mengedit summarization -->
                <form action="{{ route('transcript.update', $transcript->id) }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $summarizationText = '';
                if ($transcript->summarization && json_decode($transcript->summarization, true)) {
                    foreach (json_decode($transcript->summarization, true) as $diary) {
                        $summarizationText .= $diary['prediction'] . "\n";
                        $summarizationText .= $diary['summary'] . "\n\n";
                    }
                }
            @endphp

            <textarea name="summarization" class="w-full h-32 p-2 border rounded">{{ trim($summarizationText) }}</textarea>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">
                Ubah
            </button>
        </form>
            </div>
        </div>
    </div>
</div>

@endsection
