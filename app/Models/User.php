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
        'email_verified_at',
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
        $riwayat = collect();

        foreach ($this->kosts as $kost) {
            foreach ($kost->riwayat as $r) {
                if ($r->status_pembayaran === 'Berhasil') {
                    // Ambil nominal per bulan dan bersihkan dari format
                    $nominal = (int) preg_replace('/[^0-9]/', '', $r->nominal);
                    $durasiSewa = strtolower($r->durasi_sewa);

                    switch ($durasiSewa) {
                        case '3 bulan':
                            $total = $nominal * 3;
                            break;
                        case '6 bulan':
                            $total = $nominal * 6 * 0.95; // diskon 5%
                            break;
                        case '1 tahun':
                            $total = $nominal * 12 * 0.9; // diskon 10%
                            break;
                        default:
                            $total = $nominal; // default = 1 bulan
                    }

                    $riwayat->push($total);
                }
            }
        }

        return $riwayat->sum();
    }

    

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
