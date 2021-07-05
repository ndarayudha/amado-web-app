<?php

namespace App\Services\NotificationService;

use Illuminate\Http\Request;

interface NotificationTokenService
{
    function sendTokenNotification();
    function saveToken(Request $request);
    function deleteToken(Request $request);
    function updateToken(Request $request);
    function getToken($patient_id);
}
