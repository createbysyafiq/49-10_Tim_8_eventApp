<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    protected $fillable = [
        'nama',
        'email',
        'topik',
        'keahlian',
        'institusi',
        'portofolio',
        'no_hp',
        'foto',
    ];
}

