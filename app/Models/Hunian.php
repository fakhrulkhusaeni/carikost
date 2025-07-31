<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hunian extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'location',
        'alamat',
        'latitude', 
        'longitude',
        'user_id', // Foreign key
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kosts()
    {
        return $this->hasMany(Kost::class, 'hunian_id');
    }
}
