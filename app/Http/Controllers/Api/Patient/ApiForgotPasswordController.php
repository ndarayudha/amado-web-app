<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ForgotPasswordService\Implement\PatientForgotPasswordService;

class ApiForgotPasswordController extends Controller
{
    protected PatientForgotPasswordService $forgotPasswordService;


    public function __construct(PatientForgotPasswordService $forgotPassword)
    {
        $this->forgotPasswordService = $forgotPassword;
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');

        $token = $this->forgotPasswordService->forgotPassword($email);

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

        $isResetFailed = $this->forgotPasswordService->reset($request);

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
