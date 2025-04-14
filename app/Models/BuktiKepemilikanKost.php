<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiKepemilikanKost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kost_id',
        'shm_hgb',
        'siuk_imb',
        'ktp_pemilik',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
