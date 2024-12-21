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
            } else if ($role === 'admin') {
                return view('admin.beranda');
            }
        }

        return redirect('/login');
    }

    public function processAudio(Request $request)
    {
        // Validasi file audio
        $request->validate([
            'audio' => 'required|file|mimetypes:audio/wav,audio/x-wav|max:10240', // Maksimum 10MB
        ]);

        // Mengecek apakah file audio ada di request
        if (!$request->hasFile('audio') || !$request->file('audio')->isValid()) {
            return redirect()->back()->with('error', 'Tidak ada file audio yang diupload atau file tidak valid!');
        }

        // Tingkatkan batas waktu eksekusi menjadi 300 detik
        set_time_limit(300);

        try {
            // Ambil file audio
            $audio = $request->file('audio');

            // Simpan file audio di storage
            $audioPath = $audio->store('audio', 'public');

            // Kirim file audio ke Flask menggunakan Http::attach
            $response = Http::timeout(300)
                ->attach(
                    'audio',
                    fopen($audio->getRealPath(), 'r'),
                    $audio->getClientOriginalName()
                )
                ->post('http://127.0.0.1:9999/process-audio');

            // Debug jika ada masalah pada respons dari Flask
            if ($response->failed()) {
                return redirect()->back()->with('error', 'Gagal menghubungi Flask API: ' . $response->body());
            }

            // Periksa respons dari Flask
            if ($response->successful()) {
                // Ambil data transkripsi dan diarization dari respons Flask
                $generalTranscription = $response->json('general_transcription');
                $diarizationResults = $response->json('diarization_results');

                // Simpan hasil transkripsi ke database
                Transcripts::create([
                    'audio_name' => $audio->getClientOriginalName(),
                    'audio_url' => $audioPath,
                    'speech_to_text' => $generalTranscription,
                    'diarization' => json_encode($diarizationResults), // Simpan dalam format JSON
                    'user_id' => auth()->id(), // Menyimpan ID pengguna yang sedang login
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
        // Ambil data berdasarkan ID
        $transcript = Transcripts::findOrFail($id);

        return view('detail', compact('transcript'));
    }

    public function edit($id)
    {
        Carbon::setLocale('id');
        // Ambil data berdasarkan ID
        $transcript = Transcripts::findOrFail($id);

        return view('edit', compact('transcript'));
    }

    public function processRecordedAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:wav,mp3|max:10240', // Validasi file audio
        ]);

        // Generate nama file audio secara acak
        $audioName = 'audio_' . time() . '_' . Str::random(8) . '.' . $request->file('audio')->getClientOriginalExtension();
        $audioPath = $request->file('audio')->storeAs('uploads', $audioName, 'public');

        // Kirim ke Flask API
        $flaskApiUrl = 'http://127.0.0.1:5000/process_audio'; // Ganti dengan URL Flask API Anda
        $response = Http::attach(
            'audio',
            fopen(storage_path('app/public/' . $audioPath), 'r'),
            $audioName
        )->post($flaskApiUrl);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to process audio'], 500);
        }

        // Simpan hasil ke database
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
