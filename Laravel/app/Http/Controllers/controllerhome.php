<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transcripts;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class controllerhome extends Controller
{
    public function home()
    {
        Carbon::setLocale('id');

        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'user') {
                $user = Auth::user();
                $transcripts = Transcripts::where('user_id', $user->id)->get();
                return view('home', compact('user', 'transcripts'));
            } elseif ($role === 'admin') {
                return view('admin.beranda');
            }
        }

        return redirect('/login');
    }

    public function processAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimetypes:audio/wav,audio/x-wav|max:10240', // Maksimum 10MB
        ]);

        if (!$request->hasFile('audio') || !$request->file('audio')->isValid()) {
            return redirect()->back()->with('error', 'Tidak ada file audio yang diupload atau file tidak valid!');
        }

        set_time_limit(300);

        try {
            $audio = $request->file('audio');
            $audioPath = $audio->store('audio', 'public');

            $response = Http::timeout(300)
                ->attach(
                    'audio',
                    fopen($audio->getRealPath(), 'r'),
                    $audio->getClientOriginalName()
                )
                ->post('http://127.0.0.1:9999/process-audio');

            if ($response->failed()) {
                return redirect()->back()->with('error', 'Gagal menghubungi Flask API: ' . $response->body());
            }

            if ($response->successful()) {
                $generalTranscription = $response->json('general_transcription');
                $diarizationResults = $response->json('diarization_results');

                Transcripts::create([
                    'audio_name' => $audio->getClientOriginalName(),
                    'audio_url' => $audioPath,
                    'speech_to_text' => $generalTranscription,
                    'diarization' => json_encode($diarizationResults),
                    'user_id' => auth()->id(),
                ]);

                return redirect()->back()->with('success', 'File berhasil ditranskripsi!');
            } else {
                return redirect()->back()->with('error', 'Gagal memproses audio: ' . $response->json('error'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function caraPenggunaan()
    {
        return view('caraPenggunaan');
    }

    public function detail($id)
    {
        Carbon::setLocale('id');
        $transcript = Transcripts::findOrFail($id);
        return view('detail', compact('transcript'));
    }

    public function edit($id)
    {
        Carbon::setLocale('id');
        $transcript = Transcripts::findOrFail($id);
        return view('edit', compact('transcript'));
    }

    public function processRecordedAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:wav,mp3|max:10240',
        ]);

        $audioName = 'audio_' . time() . '_' . Str::random(8) . '.' . $request->file('audio')->getClientOriginalExtension();
        $audioPath = $request->file('audio')->storeAs('uploads', $audioName, 'public');

        $flaskApiUrl = 'http://127.0.0.1:5000/process_audio';
        $response = Http::attach(
            'audio',
            fopen(storage_path('app/public/' . $audioPath), 'r'),
            $audioName
        )->post($flaskApiUrl);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to process audio'], 500);
        }

        $transcriptData = $response->json();
        $transcript = Transcripts::create([
            'user_id' => auth()->id(),
            'audio_name' => $audioName,
            'audio_url' => asset('storage/' . $audioPath),
            'speech_to_text' => $transcriptData['transcription'],
            'diarization' => $transcriptData['diarization'],
        ]);

        return response()->json([
            'message' => 'Audio processed successfully',
            'transcript' => [
                'id' => $transcript->id,
                'audio_name' => $transcript->audio_name,
                'detail_url' => route('detail', ['id' => $transcript->id]),
            ],
        ]);
    }
}
