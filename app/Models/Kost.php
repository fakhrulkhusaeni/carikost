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
        'user_id', // Foreign key
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

    // Relasi ke Rating
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Relasi ke model Pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class);
    }

    public function buktiKepemilikan()
    {
        return $this->hasOne(BuktiKepemilikanKost::class);
    }

    // Fungsi untuk menghitung sisa kamar
    public function sisaKamar()
    {
        $terisi = $this->riwayat()
            ->where("tanggal_keluar", null)
            ->whereIn('status_konfirmasi', ['Pending', 'Disetujui'])
            ->count();

        return $this->jumlah_kamar - $terisi;
    }

    public function scopeTersedia($query)
    {
        return $query->withCount(['riwayat as kamar_terisi_count' => function ($q) {
            $q->whereNull('tanggal_keluar')
                ->whereIn('status_konfirmasi', ['Pending', 'Disetujui']);
        }])
            ->havingRaw('jumlah_kamar - kamar_terisi_count > 0');
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
                'status_verifikasi' => 'pending', // Status awal
            ]);
        });
    }
}
