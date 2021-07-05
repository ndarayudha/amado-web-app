<?php

namespace App\Services\NotificationService\Implement;

use App\Repositories\NotificationRepository\Implement\PatientNotificationRepository;
use App\Repositories\NotificationRepository\Implement\PatientNotificationTokenRepository;
use App\Repositories\NotificationRepository\Implement\PatientNotificationTopicRepository;
use App\Services\NotificationService\NotificationTokenService;
use App\Services\NotificationService\NotificationTopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

const FIREBASE_API_TOKEN_REQUIRED = false;
const TOKEN_DELETED_SUCESSFULLY = true;
const TOKEN_DELETED_FAILED = false;
const TOKEN_DOSENT_EXIST = "";
const NOTIFICATION_TOPIC_UPDATED_SUCCESSFULY = true;
const NOTIFICATION_TOPIC_UPDATED_FAILED = false;
const NOTIFICATION_TOPIC_DELETED_SUCCESSFULY = true;
const NOTIFICATION_TOPIC_DELETED_FAILED = false;
const NOTIFICATION_TOPIC_RESULT_EMPTY = "";
const NOTIFICATION_TOPIC_REQUIRED = false;
const NOTIFICATION_TOPIC_EMPTY = false;

class PatientNotificationService implements NotificationTokenService, NotificationTopicService
{

    protected PatientNotificationTopicRepository $notificationTopicRepository;
    protected PatientNotificationTokenRepository $notificationTokenRepository;


    public function __construct(PatientNotificationTopicRepository $repo1, PatientNotificationTokenRepository $repo2)
    {
        $this->notificationTopicRepository = $repo1;
        $this->notificationTokenRepository = $repo2;
    }

    /**
     * * Token Notification
     */
    public function sendTokenNotification()
    {
    }


    public function saveToken(Request $request)
    {
    }


    public function updateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebaseApiToken' => 'required'
        ]);

        if ($validator->fails()) {
            return FIREBASE_API_TOKEN_REQUIRED;
        }

        $patientHasBeenAuthenticated = $this->getCurrentPatientAuthenticated();
        $firebaseToken = $request->firebaseApiToken;

        $result = $this->notificationTokenRepository->update($patientHasBeenAuthenticated->id, $firebaseToken);

        $resultToArray = array($result);
        Log::info("updated patient firebase api token :", $resultToArray);

        return $result;
    }


    public function deleteToken(Request $request): bool
    {
        $patientHasBeenAuthenticated = $this->getCurrentPatientAuthenticated();
        $result = $this->notificationTokenRepository->delete($patientHasBeenAuthenticated->id);
        if ($result === TOKEN_DOSENT_EXIST) {
            Log::info("deleted patient firebase api token", array($patientHasBeenAuthenticated));
            return TOKEN_DELETED_SUCESSFULLY;
        }

        return TOKEN_DELETED_FAILED;
    }


    public function getToken($patient_id): string
    {
        $patientHasBeenAuthenticated = $this->getCurrentPatientAuthenticated();
        $result = $this->notificationTokenRepository->get($patientHasBeenAuthenticated->id);

        Log::info("get patient firebase api token :", $result);

        return $result;
    }


    /**
     * * Topic Notification
     */

    public function updateTopic(int $patient_id, int $topic): bool
    {
        $result = $this->notificationTopicRepository->update($patient_id, $topic);
        if ($result === NOTIFICATION_TOPIC_RESULT_EMPTY) {
            return NOTIFICATION_TOPIC_UPDATED_FAILED;
        }

        Log::info("updated topic notification patient :", $result);

        return NOTIFICATION_TOPIC_UPDATED_SUCCESSFULY;
    }


    public function deleteTopic(int $patient_id, int $topic): bool
    {
        $result = $this->notificationTopicRepository->delete($patient_id, $topic);
        $patientId = $result[0]->id;

        Log::info("Topic {$topic} has been deleted from patient id {$patientId}");

        return NOTIFICATION_TOPIC_DELETED_SUCCESSFULY;
    }


    public function getTopic(int $patient_id)
    {
        $result = $this->notificationTopicRepository->get($patient_id);

        if ($result === NOTIFICATION_TOPIC_RESULT_EMPTY) {
            return NOTIFICATION_TOPIC_EMPTY;
        }

        Log::info("get patient topics: ", $result);

        return $result;
    }


    /**
     * * Get patient has been authenticated
     */
    public function getCurrentPatientAuthenticated()
    {
        return Auth::guard('patientapi')->user();
    }
}
