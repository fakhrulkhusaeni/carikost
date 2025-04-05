<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'type',
        'jumlah_kamar',
        'location',
        'alamat',
        'harga',
        'facilities',
        'rules',
        'foto',
        'user_id', // Foreign key untuk pemilik
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Verifikasi
    public function verifikasi()
    {
        return $this->hasOne(Verifikasi::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    protected $casts = [
        'facilities' => 'array',
        'rules' => 'array',
        'foto' => 'array',
    ];

    // Tambahkan logika otomatis ke Verifikasi
    protected static function boot()
    {
        parent::boot();

        static::created(function ($kost) {
            Verifikasi::create([
                'kost_id' => $kost->id, // Hubungkan dengan kost_id
                'status' => 'pending', // Status awal
            ]);
        });
    }
}
