<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'id_tiket',
        'nama_lengkap',
        'email',
        'no_hp',
        'institusi',
        'status_pembayaran',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_tiket');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

