<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SummarizationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transcript;
    public $filePath;

    public function __construct($transcript, $filePath)
    {
        $this->transcript = $transcript;
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->subject('Transcript Summarization')
                    ->view('emails.summarization')
                    ->attach(Storage::path($this->filePath), [
                        'as' => 'transcript_summarization.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}

