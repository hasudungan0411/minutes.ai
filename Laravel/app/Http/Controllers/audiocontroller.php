<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use openAI;

class audiocontroller extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mav,mp3,m4a|max:10240', //max 10mb
        ]);

        // simpan file audio
        $path = $request->file('audio')->store('audios');

        // panggil python utk transkripsi
        $output = shell_exec("python3 /public/scripts/transcribe.py". storage_path('app/' . $path));

        // Simpan transkripsi ke database (opsional)
        // Misalnya ke tabel `notes`
        $transcript = \App\Models\transcript::create([
            'title' => 'Transkripsi Audio',
            'content' => $output,
        ]);

        return response()->json([
            'message' => 'Audio berhasil diproses.',
            'note' => $transcript,
        ]);
    }
}
