<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcripts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'audio_name',
        'speech_to_text',
        'diarization',
        'summarization',
    ];
}
