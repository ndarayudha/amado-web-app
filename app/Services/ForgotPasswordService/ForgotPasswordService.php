<?php

namespace App\Services\ForgotPasswordService;

use Illuminate\Http\Request;

interface ForgotPasswordService{
    public function forgotPassword($email);
    public function sendEmail($token, $email);
    public function reset(Request $request);
}