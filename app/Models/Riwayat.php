<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'nominal',
    ];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function token(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => Pembayaran::where("kost_id", $this->kost_id)->where("user_id", $this->user_id)->first()->transaksi_id,
        );
    }
}
