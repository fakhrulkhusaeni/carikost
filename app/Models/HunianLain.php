<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HunianLain extends Model
{
    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'nama_pemilik',
        'deskripsi',
        'tipe_hunian',
        'harga',
        'status',
        'location',
        'alamat',
        'telepon',
        'status_verifikasi',
        'detail_hunian',
        'fasilitas',
        'foto',
        'bukti_kepemilikan',
    ];

    // Casting kolom menjadi tipe data tertentu
    protected $casts = [
        'detail_hunian' => 'array',
        'fasilitas' => 'array',
        'foto' => 'array',
        'bukti_kepemilikan' => 'array',
    ];
}
