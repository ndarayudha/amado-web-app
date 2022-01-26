<?php

namespace App\Http\Controllers\ApiWeb;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthApi\Implement\DoctorAuthService;
use Exception;

class DoctorAuthController extends Controller
{
    protected DoctorAuthService $doctorAuthService;

    public function __construct(
        DoctorAuthService $doctorAuthService
    ) {
        $this->doctorAuthService = $doctorAuthService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $doctor = $this->doctorAuthService->register($request);
            $token = $this->doctorAuthService->createAccessToken($doctor);

            return response()->json([
                'code' => 201,
                'status' => 'berhasil',
                'token_type' => 'Bearer',
                'access_token' => $token->accessToken,
                'token_id' => $token->token->id,
                'user' => [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'email' => $doctor->email,
                    'created_at' => $doctor->created_at,
                    'updated_at' => $doctor->updated_at,
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'gagal',
                'message' => 'Email sudah digunakan'
            ], 400);
        }
    }



    public function login(LoginRequest $request)
    {

        $doctor = $this->doctorAuthService->login($request);

        if ($doctor != null) {

            $token = $this->doctorAuthService->recreateAccessToken($doctor);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'token_type' => 'Bearer',
                'access_token' => $token->accessToken,
                'token_id' => $token->token->id,
                'user' => [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'email' => $doctor->email,
                    'created_at' => $doctor->created_at,
                    'updated_at' => $doctor->updated_at,
                ]
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 'gagal',
                'message' => 'cek email dan password'
            ], 400);
        }
    }



    public function logout(LogoutRequest $request)
    {

        $isLogout = $this->doctorAuthService->logout($request);

        if ($isLogout) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'logout berhasil'
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 'gagal',
                'message' => 'token id tidak ditemukan'
            ], 400);
        }
    }
}
