<?php

namespace App\Repositories\AuthApi\Implement;

use App\Models\Patient\Patient;
use App\Repositories\AuthApi\AuthRepository;
use Exception;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\Token;

class PatientAuthRepository implements AuthRepository
{


    protected $patientModel;

    public function __construct(Patient $model)
    {
        $this->patientModel = $model;
    }


    public function saveUser(array $request): Object
    {
        return $this->patientModel::create($request);
    }


    public function deleteAccessToken($token_id): bool
    {
        try {
            $tokenRepository = app(TokenRepository::class);

            $patientToken = $tokenRepository->find($token_id);

            if ($patientToken != null) {
                Token::where('id', $token_id)->delete();
                // $tokenRepository->revokeAccessToken($token_id);
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }


    public function saveAccessToken($patient)
    {
        return $patient->save();
    }


    public function getTokenId($user_id)
    {
        $tokenRepository = app(TokenRepository::class);
        $token = $tokenRepository->forUser($user_id)->all();

        if ($token == null) {
            return null;
        } else {
            return $token[0]->id;
        }
    }
}
