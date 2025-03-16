<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Riwayat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kost_id',
        'user_id',
        'tanggal_booking',
        'status_konfirmasi',
        'status_pembayaran',
        'kartu_identitas',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class); // Relasi ke tabel Kost
    }
}
