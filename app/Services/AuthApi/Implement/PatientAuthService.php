<?php

namespace App\Services\AuthApi\Implement;

use App\Events\PatientRegisteredEvent;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Doctor;
use App\Notifications\PatientRegisteredNotification;
use App\Repositories\AuthApi\Implement\PatientAuthRepository;
use App\Services\AuthApi\AuthService;
use App\Services\NotificationService\Implement\PatientNotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PatientAuthService implements AuthService
{

    protected PatientAuthRepository $patientAuthRepository;
    protected PatientNotificationService $notificationService;


    public function __construct(
        PatientAuthRepository $patientRepository,
        PatientNotificationService $notificationService
    ) {
        $this->patientAuthRepository = $patientRepository;
        $this->notificationService = $notificationService;
    }


    public function login(LoginRequest $request)
    {
        if ($request->validated()) {
            $loginData = collect($request);

            config(['auth.guards.api.provider' => 'patient']);

            Auth::guard('patient')->attempt($loginData->all());

            $patient = Auth::guard('patient')->user();

            if ($patient !== null) {
                // attach notification
                $this->notificationService->updateTopic($patient->id, ID_GENERAL_NEW_USER);

                // Create Job to Process Notification
                // ProcessNotification::dispatch($patient->id, ID_GENERAL_NEW_USER)->delay(now()->addMinute(1));

                Log::info("Patient has been login", array($patient));

                return $patient;
            }

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

            $patientData = $this->patientAuthRepository->saveUser($dataWithHashPassword->all());

            event(new PatientRegisteredEvent($patientData));
            $doctor = Doctor::find(1);
            Notification::send($doctor, new PatientRegisteredNotification($patientData));
            // // attach notification
            // $this->notificationService->updateTopic($patientData->id, ID_GENERAL_NEW_USER);

            // // Create Job to Process Notification
            // ProcessNotification::dispatch($patientData->id, ID_GENERAL_NEW_USER)
            //     ->delay(now()->addMinutes(1));

            Log::info("Patient has been register", array($patientData));
            return $patientData;
        }
    }

    public function logout(LogoutRequest $request): bool
    {
        if ($request->validated()) {

            $isDeleted = $this->patientAuthRepository->revokeToken($request->token_id);

            return $isDeleted;
        } else {
            return false;
        }
    }

    public function createAccessToken($patient)
    {
        $tokenResult = $patient->createToken('AccessToken', ['patient']);
        $token = $tokenResult->token;

        $this->patientAuthRepository->saveAccessToken($token);

        return $tokenResult;
    }

    public function recreateAccessToken($patient)
    {
        $patientTokenId = $this->patientAuthRepository->getTokenId($patient->id);

        if ($patientTokenId != null) {
            $isDeleted = $this->patientAuthRepository->deleteAccessToken($patientTokenId);

            if ($isDeleted) {
                $patientNewAccessToken = $this->createAccessToken($patient);
                return $patientNewAccessToken;
            }
        }

        return;
    }
}
