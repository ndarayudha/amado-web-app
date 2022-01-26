<?php

namespace App\Services\AuthApi\Implement;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthApi\Implement\DoctorAuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\AuthApi\AuthService;

class DoctorAuthService implements AuthService
{
    protected DoctorAuthRepository $doctorAuthRepository;


    public function __construct(
        DoctorAuthRepository $doctorAuthRepository
    ) {
        $this->doctorAuthRepository = $doctorAuthRepository;
    }


    public function login(LoginRequest $request)
    {
        if ($request->validated()) {
            $loginData = collect($request);

            Auth::guard('doctor')->attempt($loginData->all());

            $doctor = Auth::guard('doctor')->user();

            if ($doctor !== null) {

                Log::info("Doctor has been login", array($doctor));

                return $doctor;
            }

            Log::info("Doctor failed to login");
            return;
        }
    }

    public function register(RegisterRequest $request)
    {

        if ($request->validated()) {
            $dataExceptPassword = collect($request->except('password'));
            $dataWithHashPassword = $dataExceptPassword->merge([
                'password' => bcrypt($request->password)
            ]);

            $doctorData = $this->doctorAuthRepository->saveUser($dataWithHashPassword->all());

            Log::info("Doctor has been register", array($doctorData));
            return $doctorData;
        }
    }

    public function logout(LogoutRequest $request): bool
    {
        if ($request->validated()) {

            $isDeleted = $this->doctorAuthRepository->revokeToken($request->token_id);

            return $isDeleted;
        } else {
            return false;
        }
    }

    public function createAccessToken($doctor)
    {
        $tokenResult = $doctor->createToken('AccessToken', ['doctor']);
        $token = $tokenResult->token;

        $this->doctorAuthRepository->saveAccessToken($token);

        return $tokenResult;
    }

    public function recreateAccessToken($doctor)
    {
        $doctorTokenId = $this->doctorAuthRepository->getTokenId($doctor->id);

        if ($doctorTokenId != null) {
            $isDeleted = $this->doctorAuthRepository->deleteAccessToken($doctorTokenId);

            if ($isDeleted) {
                $doctorNewAccessToken = $this->createAccessToken($doctor);
                return $doctorNewAccessToken;
            }
        }

        return;
    }
}
