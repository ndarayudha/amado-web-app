<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

class Doctor extends Model implements CanResetPassword
{
    use Notifiable, HasApiTokens;

    protected $guard = 'doctor';

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
        'specialist'
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
