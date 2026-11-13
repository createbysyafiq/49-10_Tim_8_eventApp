<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'judul_event',
        'deskripsi',
        'kategori',
        'silabus',
        'durasi_sesi',
        'tanggal_mulai',
        'lokasi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];
}

