<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadSummaryController extends Controller
{
    // Menampilkan data transcripts di view
    public function index()
    {
        // Mengambil semua data dari tabel transcripts
        $transcripts = DB::table('transcripts')->get();

        return view('transcripts.index', compact('transcripts'));
    }

    // Fungsi untuk mendownload summary berdasarkan ID
    public function download($id)
    {
        // Cari transcript berdasarkan ID
        $transcript = DB::table('transcripts')->where('id', $id)->first();

        // Jika data tidak ditemukan atau summary kosong
        if (!$transcript || !$transcript->summarization) {
            return redirect()->route('transcripts.index')->with('error', 'Summary not found or empty!');
        }

        // Membuat file response untuk download
        $response = new StreamedResponse(function () use ($transcript) {
            echo $transcript->summarization;
        });

        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('Content-Disposition', 'attachment; filename="summary_' . $transcript->audio_name . '.txt"');

        return $response;
    }
}