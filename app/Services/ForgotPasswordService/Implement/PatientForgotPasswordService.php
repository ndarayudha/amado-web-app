<?php

namespace App\Services\ForgotPasswordService\Implement;

use App\Repositories\ForgotPasswordRepository\Implement\PatientForgotPasswordRepository;
use App\Services\ForgotPasswordService\ForgotPasswordService;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


const TOKEN_DOES_NOT_EXIST = true;
const VALIDATOR_FAILS = true;


class PatientForgotPasswordService implements ForgotPasswordService{

    protected $forgotPasswordRepository;
    

    public function __construct(PatientForgotPasswordRepository $repo)
    {
        $this->forgotPasswordRepository = $repo;
    }


    public function forgotPassword($email)
    {
        $token = Str::random(50);

        $isPatientEmailDosentExist = $this->forgotPasswordRepository->forgot($email, $token);

        if($isPatientEmailDosentExist){
            return;
        }

        return $token;
    }


    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);


        if($validator->fails()){
            return VALIDATOR_FAILS;
        } else {
            $token = $request->input('token');
            $isTokenExist = $this->forgotPasswordRepository->getToken($token);

            if(!$isTokenExist){
                return TOKEN_DOES_NOT_EXIST;
            }

            $email = $this->forgotPasswordRepository->getEmailByToken($token);
            $newPassword = Hash::make($request->password);

            $this->forgotPasswordRepository->updatePassword($newPassword, $email);
        }
        
    }


    public function sendEmail($token, $email)
    {
        Mail::send('auth.passwords.forgot', ['token' => $token], function(Message $message) use ($email){
            $message->to($email);
            $message->subject('Reset your password');
        });
    }
}