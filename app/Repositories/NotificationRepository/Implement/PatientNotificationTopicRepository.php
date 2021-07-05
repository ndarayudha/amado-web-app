<?php

namespace App\Repositories\NotificationRepository\Implement;


use App\Models\Patient\Patient;
use App\Models\Notification\Notification;
use App\Repositories\NotificationRepository\NotificationTopicRepository;
use Illuminate\Support\Facades\Log;

class PatientNotificationTopicRepository implements NotificationTopicRepository
{

    protected $patientModel;
    protected $notification;

    public function __construct(Patient $model, Notification $notification)
    {
        $this->patientModel = $model;
        $this->notification = $notification;
    }

    function delete(int $patient_id, int $topic): array
    {
        $patient = $this->patientModel::find($patient_id);
        Log::info("find patient model with id {$patient_id}");

        $patient->notificationTemplate()->detach($topic);
        Log::info("Detach patient with notification id {$topic}");

        return $this->patientModel::find($patient_id)->notificationTemplate()->get()->all();
        Log::info("Return patient notification that has been attached");
    }

    function update(int $patient_id, int $topic): array
    {
        $patient = $this->patientModel::find($patient_id);
        Log::info("find patient model with id {$patient_id}");

        $patient->notificationTemplate()->attach($topic);
        Log::info("Attach patient with notification id {$topic}");

        return $this->patientModel::find($patient_id)->notificationTemplate()->get()->all();
        Log::info("Return patient notification that has been attached");
    }

    function get(int $patient_id): array
    {
        return $this->patientModel::find($patient_id)->notificationTemplate()->get()->all();

        Log::info("get all topics from patient id {$patient_id}");
    }
}
