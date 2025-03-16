<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    // Daftar kolom yang dapat diisi
    protected $fillable = ['rating', 'kost_id', 'user_id'];

    /**
     * Relasi ke model Kost
     * Satu rating terkait dengan satu tempat kost
     */
    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    /**
     * Relasi ke model User
     * Satu rating dibuat oleh satu pengguna
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
