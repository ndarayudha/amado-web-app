<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use App\Services\AuthApi\Implement\PatientAuthService;
use App\Services\UserService\Implement\PatientService;

class PatientAuthApiController extends Controller
{
    protected $patientAuthService;
    protected $patientService;

    public function __construct(
        PatientAuthService $patientAuth,
        PatientService $patientService
    ) {
        $this->patientAuthService = $patientAuth;
        $this->patientService = $patientService;
    }


    // Handle register patient
    public function register(RegisterRequest $request)
    {

        try {
            $patient = $this->patientAuthService->register($request);
            $token = $this->patientAuthService->createAccessToken($patient);

            return response()->json([
                'code' => 201,
                'status' => 'berhasil',
                'token_type' => 'Bearer',
                'access_token' => $token->accessToken,
                'token_id' => $token->token->id,
                'user' => [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'email' => $patient->email,
                    'created_at' => $patient->created_at,
                    'updated_at' => $patient->updated_at,
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


    // Handle Login Patient
    public function login(LoginRequest $request)
    {

        $patient = $this->patientAuthService->login($request);

        if ($patient != null) {

            $token = $this->patientAuthService->createAccessToken($patient);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'token_type' => 'Bearer',
                'access_token' => $token->accessToken,
                'token_id' => $token->token->id,
                'user' => [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'email' => $patient->email,
                    'created_at' => $patient->created_at,
                    'updated_at' => $patient->updated_at,
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


    // Handle Logout Patient
    public function logout(LogoutRequest $request)
    {

        $isLogout = $this->patientAuthService->logout($request);

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
