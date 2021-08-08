<?php

namespace App\Http\Controllers\ApiWeb;

use App\Http\Controllers\Controller;
use App\Services\ForgotPasswordService\Implement\DoctorForgotPasswordService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected DoctorForgotPasswordService $doctorForgotPasswordService;

    public function __construct(DoctorForgotPasswordService $doctorForgotPasswordService)
    {
        $this->doctorForgotPasswordService = $doctorForgotPasswordService;
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');

        $token = $this->doctorForgotPasswordService->forgotPassword($email);

        if ($token != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'token' => $token
            ], 200);
        }

        return response()->json([
            'code' => 404,
            'status' => 'gagal',
            'message' => 'email doesnt exist'
        ], 404);
    }

    public function resetPassword(Request $request)
    {

        $isResetFailed = $this->doctorForgotPasswordService->reset($request);

        if ($isResetFailed) {
            return response()->json([
                'code' => 400,
                'status' => 'failed',
                'message' => 'check your param or invalid token'
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'password reset successful'
        ], 200);
    }
}
