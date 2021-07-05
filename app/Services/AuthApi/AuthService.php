<?php

namespace App\Services\AuthApi;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;

interface AuthService{
    public function login(LoginRequest $request);
    public function register(RegisterRequest $request);
    public function logout(LogoutRequest $request): bool;
    public function createAccessToken($user);
    public function recreateAccessToken($patient);
}