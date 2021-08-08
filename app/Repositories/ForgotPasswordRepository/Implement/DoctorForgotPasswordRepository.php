<?php

namespace App\Repositories\ForgotPasswordRepository\Implement;

use App\Models\Doctor;
use App\Repositories\ForgotPasswordRepository\ForgotPasswordRepository;
use Illuminate\Support\Facades\DB;

class DoctorForgotPasswordRepository implements ForgotPasswordRepository
{
    protected Doctor $doctor;

    public function __construct(Doctor $model)
    {
        $this->doctor = $model;
    }


    public function forgot($email, $token)
    {
        $isEmailDosentExist = $this->doctor::where('email', $email)->doesntExist();

        if ($isEmailDosentExist) {
            return true;
        }

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token
        ]);

        return false;
    }


    public function getToken($token)
    {
        $isTokenExist = DB::table('password_resets')->where('token', $token)->first();

        if (!$isTokenExist) {
            return false;
        }

        return true;
    }


    public function getEmailByToken($token)
    {
        $email = DB::table('password_resets')->where('token', $token)->value('email');
        return $email;
    }


    public function updatePassword($newPassword, $email)
    {
        $this->doctor::where('email', $email)->update([
            'password' => $newPassword
        ]);
    }
}
