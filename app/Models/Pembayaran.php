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
        'status_konfirmasi',
        'kartu_identitas',
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
}
