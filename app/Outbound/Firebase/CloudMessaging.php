<?php

namespace App\Outbound\Firebase;

use App\Models\Notification\NotificationTemplate;

interface CloudMessaging
{
    function sendApiTokenNotification(int $patientId, int $notification): void;
    function sendTopicNotification($topic, $title, $body): void;
    function getNotificationTemplate(int $notificationID);
}
