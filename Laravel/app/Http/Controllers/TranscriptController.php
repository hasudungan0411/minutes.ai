<?php

namespace App\Http\Controllers;

use App\Mail\SummarizationMail;
use App\Models\Transcripts;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TranscriptController extends Controller
{
    public function shareEmail($id, Request $request)
    {
        $recipientEmail = $request->input('email');

        try {
            // Ambil data transcript berdasarkan ID
            $transcript = Transcripts::find($id);

            // Debugging: jika transcript tidak ditemukan
            if (!$transcript) {
                return response()->json(['error' => 'Transcript not found'], 404);
            }

            // Debugging: jika summarization kosong
            if (empty($transcript->summarization)) {
                return response()->json(['error' => 'Summarization is empty'], 404);
            }

            // **Langkah 1: Buat PDF dari data JSON langsung**
            $DataText = $transcript->speech_to_text;
            $jsonDataDiarization = json_decode($transcript->diarization, true);
            $jsonDataSummary = json_decode($transcript->summarization, true); 

            // Mulai membuat HTML
            $html = '<h1 style="text-align: center; color: #333;">Summarization</h1>';
            $html .= '<div style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6;">';

            $html .= '<p><strong>Summary:</strong> <br/></p>';
            
            foreach ($jsonDataSummary as $item) {
                $html .= '<p>' . htmlspecialchars($item['summary']) . ' - <strong>' . htmlspecialchars($item['prediction']) . '</strong></p>';
                
            }
            
            $html .= '<hr>'; // Garis horizontal untuk pemisah antar entri
            $html .= '</div>';

            // Buat PDF dari HTML
            $pdf = Pdf::loadHTML($html);

            $pdf = Pdf::loadHTML($html);

            // Simpan file PDF sementara di storage
            $fileName = 'summarization_' . $transcript->id . '.pdf';
            $filePath = 'pdfs/' . $fileName;
            Storage::put($filePath, $pdf->output());

            // **Langkah 2: Kirim email dengan PDF sebagai lampiran**
            Mail::to($recipientEmail)->send(new SummarizationMail($transcript, $filePath));

            // Hapus PDF setelah email terkirim (opsional)
            Storage::delete($filePath);

            // Berikan respon sukses
            return redirect()->back()->with('success', 'Ringkasan berhasil dikirim!');

        } catch (\Exception $e) {
            // Tangani error saat mengirim email
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
