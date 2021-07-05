<?php

namespace App\Repositories\NotificationRepository\Implement;

use App\Models\Notification\Notification;
use App\Models\Patient\Patient;
use App\Repositories\NotificationRepository\NotificationTokenRepository;
use Illuminate\Support\Facades\Log;

class PatientNotificationTokenRepository implements NotificationTokenRepository
{

    protected $patientModel;
    protected $notification;

    public function __construct(Patient $model, Notification $notification)
    {
        $this->patientModel = $model;
        $this->notification = $notification;
    }

    /**
     * * Handle Firebase API token
     */
    // TODO hapus fungsi

    public function delete(int $patient_id, string $token = ""): string
    {
        $this->patientModel::where('id', $patient_id)->update(['firebase_api_token' => $token]);

        Log::info('Delete firebase api token to empty string: patientModel::where("id", $patient_id)->update(["firebase_api_token" => $token]);');

        return $this->patientModel::find($patient_id)->firebase_api_token;
    }


    public function update(int $patient_id, string $token = ""): Patient
    {
        $this->patientModel::where('id', $patient_id)->update(['firebase_api_token' => $token]);

        Log::info('Update firebase api token: patientModel::where("id", $patient_id)->update(["firebase_api_token" => $token])');

        return $this->patientModel::find($patient_id);
    }


    public function get(int $patient_id): string
    {
        return $this->patientModel::find($patient_id)->firebase_api_token;

        Log::info("Get patient firebase api token");
    }
}
