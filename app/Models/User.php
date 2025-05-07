<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'gender',
    ];

    // Relasi ke Kost
    public function kosts()
    {
        return $this->hasMany(Kost::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function saldo(): Attribute
    {
        return Attribute::make(
            get: fn(?int $value) => $this->returnSaldo(),
        );
    }

    protected function returnSaldo()
    {
        $riwayat = [];
        $this->kosts->each(function ($kost, int $key) use (&$riwayat) {
            $kost->riwayat->each(function ($r, int $keyZ) use (&$riwayat) {
                if ($r->status_pembayaran == "Berhasil") {
                    $riwayat[] = $r->kost->harga;
                }
            });
        });
        return collect($riwayat)->map(function (string $value) {
            return (int) preg_replace('/[^0-9]/', '', $value);
        })->sum();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
