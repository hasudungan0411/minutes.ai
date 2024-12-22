<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadSummaryController extends Controller
{

    // Fungsi untuk mendownload summary berdasarkan ID
    public function download($id)
    {
        // Cari transcript berdasarkan ID
        $transcript = DB::table('transcripts')->where('id', $id)->first();
    
        // Jika data tidak ditemukan atau summary kosong
        if (!$transcript || !$transcript->summarization) {
            return back()->with('error', 'Ringkasan belum ada, silahkan pencet tombol Buat ringkasan');
        }
    
        // Decode JSON dari summarization
        $summarizationArray = json_decode($transcript->summarization, true);
    
        // Ubah JSON menjadi string yang mudah dibaca
        $summarizationText = '';
        if (is_array($summarizationArray)) {
            foreach ($summarizationArray as $summary) {
                $summarizationText .= "Prediksi: " . ($summary['prediction'] ?? '-') . "\n";
                $summarizationText .= "Hasil Ringkasan: " . ($summary['summary'] ?? '-') . "\n\n";
            }
        } else {
            $summarizationText = "Data ringkasan tidak valid.";
        }
    
        // Membuat file response untuk download
        $response = new StreamedResponse(function () use ($summarizationText) {
            echo $summarizationText;
        });
    
        $response->headers->set('Content-Type', 'text/plain');
        $response->headers->set('Content-Disposition', 'attachment; filename="summary_' . $transcript->audio_name . '.txt"');
    
        return $response;
    }
}