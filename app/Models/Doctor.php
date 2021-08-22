<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Models\RiwayatPenanganan;

class Doctor extends Model implements CanResetPassword
{
    use Notifiable, HasApiTokens;

    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'photo',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    // has one rumah RumahSakit
    public function hospitals()
    {
        return $this->belongsToMany(RumahSakit::class);
    }

    // has specialist
    public function specialists()
    {
        return $this->belongsToMany(Specialist::class);
    }

    public function riwayatPenangnanans()
    {
        return $this->belongsToMany(RiwayatPenanganan::class);
    }
}
