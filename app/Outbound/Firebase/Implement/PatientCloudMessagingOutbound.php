<?php

namespace App\Outbound\Firebase\Implement;

use App\Models\Notification\NotificationTemplate;
use App\Outbound\Firebase\CloudMessaging;
use App\Repositories\UserRepository\Implement\PatientRepository;
use Illuminate\Support\Facades\Log;

class PatientCloudMessagingOutbound implements CloudMessaging
{

    protected PatientRepository $patientRepository;
    protected NotificationTemplate $notificaionTemplate;


    public function __construct(
        PatientRepository $patientRepository,
        NotificationTemplate $notifTemplate
    ) {
        $this->patientRepository = $patientRepository;
        $this->notificaionTemplate = $notifTemplate;
    }


    public function sendApiTokenNotification(int $patientId, int $notificationId): void
    {
        $patientFirebaseToken = $this->patientRepository->getPatient($patientId)->firebase_api_token;
        $patientNotificationTemplate = $this->getNotificationTemplate($notificationId);
        $notificationBody = $patientNotificationTemplate->description;
        $notificationTitle = $patientNotificationTemplate->title;

        Log::info("Send notification to patient ID {$patientId} with notification ID {$notificationId}, title : {$notificationTitle} body: {$notificationBody}");

        fcm()
            ->to(array($patientFirebaseToken))
            ->priority('normal')
            ->timeToLive(0)
            ->notification([
                'title' => "{$notificationTitle}",
                'body' => "{$notificationBody}",
                'image' => 'https://i.ibb.co/ssb5mKk/amado.png'
            ])
            ->send();
    }


    public function sendTopicNotification($topic, $title, $body): void
    {
        fcm()
            ->toTopic()
            ->priority('normal')
            ->timeToLive(0)
            ->notification([
                'title' => "{$title}",
                'body' => "{$body}",
                'image' => 'https://i.ibb.co/ssb5mKk/amado.png'
            ])
            ->send();
    }


    public function getNotificationTemplate(int $notificationID)
    {
        return $this->notificaionTemplate::find($notificationID);
    }
}
