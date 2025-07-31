<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kost_id',
        'user_id',
        'tanggal_booking',
        'durasi_sewa',
        'status_konfirmasi',
        'catatan_penolakan',
        'status_pembayaran',
        'kartu_identitas',
        'nominal',
        'tanggal_keluar',
        'transaksi_id',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Kost.
     */
    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function riwayat()
    {
        return $this->hasOne(Riwayat::class, 'transaksi_id', 'transaksi_id');
    }
}
