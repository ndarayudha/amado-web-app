<?php


namespace App\Repositories\ForgotPasswordRepository;

interface ForgotPasswordRepository{
    public function forgot($email, $token);
    public function getToken($token);
    public function getEmailByToken($email);
    public function updatePassword($newPassword, $email);
}