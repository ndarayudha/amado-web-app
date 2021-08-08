<?php

namespace App\Services\ForgotPasswordService\Implement;

use App\Repositories\ForgotPasswordRepository\Implement\DoctorForgotPasswordRepository;
use App\Services\ForgotPasswordService\ForgotPasswordService;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


const TOKEN_DOES_NOT_EXIST = true;
const VALIDATOR_FAILS = true;


class DoctorForgotPasswordService implements ForgotPasswordService
{

    protected DoctorForgotPasswordRepository $doctorForgotPasswordRepository;


    public function __construct(DoctorForgotPasswordRepository $doctorForgotPasswordRepository)
    {
        $this->doctorForgotPasswordRepository = $doctorForgotPasswordRepository;
    }


    public function forgotPassword($email)
    {

        $token = Str::random(50);

        $isDoctorEmailDosentExist = $this->doctorForgotPasswordRepository->forgot($email, $token);

        if ($isDoctorEmailDosentExist) {
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

        if ($validator->fails()) {
            return VALIDATOR_FAILS;
        } else {
            $token = $request->input('token');
            $isTokenExist = $this->doctorForgotPasswordRepository->getToken($token);

            if (!$isTokenExist) {
                return TOKEN_DOES_NOT_EXIST;
            }

            $email = $this->doctorForgotPasswordRepository->getEmailByToken($token);
            $newPassword = Hash::make($request->password);

            $this->doctorForgotPasswordRepository->updatePassword($newPassword, $email);
        }
    }


    /**
     * TODO: next via email
     */
    public function sendEmail($token, $email)
    {
        Mail::send('auth.passwords.forgot', ['token' => $token], function (Message $message) use ($email) {
            $message->to($email);
            $message->subject('Reset your password');
        });
    }
}
