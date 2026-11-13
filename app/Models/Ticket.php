<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'tipe_tiket',
        'harga',
        'kuota',
        'benefit',
        'gambar',
    ];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'id_tiket');
    }
}
