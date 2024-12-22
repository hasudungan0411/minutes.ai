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
        // Validasi file audio
        $request->validate([
            'audio' => 'required|file|mimes:wav|max:10240', // Maksimum 10MB
        ], [
            'audio.required' => 'Harus ada file audio yang di upload',
            'audio.file' => 'File audio harus berupa file',
            'audio.mimes' => 'File audio harus memiliki tipe WAV',
            'audio.max' => 'File audio tidak boleh lebih dari 10 MB'
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
        $transcript = Transcripts::findOrFail($id);
        return view('detail', compact('transcript'));
    }

    public function edit($id)
    {
        Carbon::setLocale('id');
        $transcript = Transcripts::findOrFail($id);
        return view('edit', compact('transcript'));
    }

    public function update(Request $request, $id)
{
    $transcript = Transcripts::findOrFail($id);

    // Ambil input dari textarea
    $input = $request->input('summarization');

    // Pisahkan data menjadi array per baris
    $lines = array_filter(explode("\n", $input), 'trim'); // Hapus baris kosong

    // Parsing data
    $summarization = [];
    for ($i = 0; $i < count($lines); $i += 2) {
        if (isset($lines[$i]) && isset($lines[$i + 1])) {
            $summarization[] = [
                'prediction' => trim($lines[$i]),       // Baris prediksi
                'summary' => trim($lines[$i + 1])      // Baris hasil ringkasan
            ];
        }
    }

    // Konversi ke JSON
    $summarizationJson = json_encode($summarization);

    // Simpan ke database
    $transcript->summarization = $summarizationJson;
    $transcript->save();

    // Redirect dengan pesan sukses
    return redirect()->route('detail', $id)->with('success', 'Ringkasan berhasil diperbarui.');
}

    

public function summarize(Request $request, $id)
{
    // Ambil data transcript berdasarkan ID
    $transcript = Transcripts::findOrFail($id);
    $diarizationData = json_decode($transcript->diarization, true); // Ambil diarization dari database dan decode

    if (!$diarizationData) {
        return redirect()->back()->with('error', 'Tidak ada data diarization untuk transcript ini!');
    }

    // Kirim data diarization ke Flask
    try {
        $response = Http::timeout(300) // Set timeout agar tidak terlalu cepat gagal
            ->post('http://127.0.0.1:9999/process-text', $diarizationData);

        // Cek apakah Flask berhasil merespons
        if ($response->successful()) {
            // Ambil data hasil dari Flask
            $responseData = $response->json();
            
            // Cek apakah 'results' ada dalam response
            if (isset($responseData['results'])) {
                // Simpan hasil summary sebagai JSON dalam kolom 'summarization'
                $transcript->summarization = json_encode($responseData['results']);
                
                // Simpan perubahan di database
                $transcript->save();
        
                // Redirect kembali dengan pesan sukses
                return redirect()->back()->with('success', 'Ringkasan berhasil dibuat!')->with('summary', $responseData['results']);
            } else {
                // Jika tidak ada 'results' dalam respons Flask, kirimkan pesan error
                return redirect()->back()->with('error', 'Flask tidak mengembalikan data yang valid.');
            }
        } else {
            // Jika respons dari Flask tidak berhasil, kirimkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam permintaan ke Flask.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghubungi Flask: ' . $e->getMessage());
    }
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
