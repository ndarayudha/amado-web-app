<?php

namespace App\Http\Controllers;

use App\Models\GoogleAuth;
use Illuminate\Http\Request;
use Hybridauth\Provider\Google;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailController extends Controller
{

    public $adapter = null;

    public $config = [
        'callback' => 'http://localhost:8000/mail/send',
        'keys'     => [
            'id' => '507914255970-6v98q3qt5v2rvhoa48kul00pfgslu5k7.apps.googleusercontent.com',
            'secret' => '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'
        ],
        'scope'    => 'https://mail.google.com',
        'authorize_url_parameters' => [
            'approval_prompt' => 'force', // to pass only when you need to acquire a new refresh token.
            'access_type' => 'offline'
        ]
    ];

    public function __construct()
    {
    }

    public function send()
    {
        try {
            $this->adapter = new Google($this->config);
            $this->adapter->authenticate();

            $token = $this->adapter->getAccessToken();

            GoogleAuth::create([
                'access_token' => $token['access_token'],
                'token_type' => $token['token_type'],
                'refresh_token' => $token['refresh_token'],
                'expires_in' => $token['expires_in'],
                'expires_at' => $token['expires_at']
            ]);

            echo "Access token inserted successfully.";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function sendKonfirmasiEmail()
    {
        $access_token = $this->getAccessToken();
        
        try {

            $transport = Transport::fromDsn('gmail://'.urlencode('yofan.ixe@gmail.com').':'.urlencode($access_token['access_token']).'@default');

            $mailer = new Mailer($transport);

            $message = (new Email())
                ->from('yofan.ixe@gmail.com')
                ->to('yofan.ixe@gmail.com')
                ->subject('Email through Gmail API')
                ->html('<h2>Email sent through Gmail API</h2>');

            // Send the message
            $mailer->send($message);

            echo 'Email sent successfully.';
        } catch (Exception $e) {
            echo $e->getMessage();
            // if (!$e->getCode()) {
            //     $refresh_token = $this->getRefreshToken();

            //     $response = $this->adapter->refreshAccessToken([
            //         "grant_type" => "refresh_token",
            //         "refresh_token" => $refresh_token,
            //         "client_id" => '507914255970-6v98q3qt5v2rvhoa48kul00pfgslu5k7.apps.googleusercontent.com',
            //         "client_secret" => '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',
            //     ]);

            //     $this->updateAccessToken($response);
            // } else {
            //     echo $e->getMessage(); //print the error
            // }
        }
    }


    public function getAccessToken()
    {
        $token = GoogleAuth::get('access_token')->first();

        return $token;
    }

    public function getRefreshToken()
    {
        $refreshToken = GoogleAuth::get('refresh_token')->first();

        return $refreshToken;
    }

    public function updateAccessToken($token)
    {
        $updateToken = GoogleAuth::find(1);

        $updateToken->update([
            'access_token' => $token['access_token'],
            'token_type' => $token['token_type'],
            'refresh_token' => $token['refresh_token'],
            'expires_in' => $token['expires_in'],
            'expires_at' => $token['expires_at']
        ]);

        return $updateToken;
    }
}
