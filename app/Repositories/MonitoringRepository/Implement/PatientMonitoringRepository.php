<?php

namespace App\Repositories\MonitoringRepository\Implement;

use App\Models\Hardware\PulseOximetry;
use App\Models\Monitoring\Monitoring;
use App\Models\Patient\Patient;
use App\Repositories\MonitoringRepository\MonitoringRepository;
use App\Repositories\UserRepository\Implement\PatientRepository;
use Illuminate\Support\Facades\Log;

class PatientMonitoringRepository implements MonitoringRepository
{
    protected Patient $patientModel;
    private Monitoring $monitoring;
    private PatientRepository $patientRepository;
    private PulseOximetry $pulseOximetry;

    public function __construct(
        Patient $model,
        Monitoring $monitoring,
        PatientRepository $patientRepository,
        PulseOximetry $pulseOximetry
    ) {
        $this->patientModel = $model;
        $this->monitoring = $monitoring;
        $this->patientRepository = $patientRepository;
        $this->pulseOximetry = $pulseOximetry;
    }

    public function update(int $patient_id, int $currentUpdateStatus)
    {
        $result = $this->patientModel::find($patient_id)->monitoring()->update([
            'total_monitoring' => $currentUpdateStatus
        ]);


        Log::info("Updated current total monitoring for patient id {$patient_id}");

        return $result;
    }

    public function create(int $patient_id, int $initialValue)
    {
        $result = $this->patientModel::find($patient_id)->monitoring()->create([
            'total_monitoring' => $initialValue
        ]);

        Log::info("Ititialing total monitoring value for patient id {$patient_id}");

        return $result;
    }

    public function get(int $patient_id)
    {
        return $this->patientModel::find($patient_id)->monitoring()->get()->all()[0]->total_monitoring;
    }



    /**
     * * Sementara
     */
    public function getPatientMonitoring(int $patient_id)
    {
        $result = $this->monitoring::where('patient_id', $patient_id)->get(['patient_id', 'total_monitoring', 'updated_at']);
        return $result ? $result : null;
    }

    public function getPhoto(int $patient_id)
    {
        $imagePath = $this->patientRepository->getPhotoProfile($patient_id);

        if ($imagePath != null) {
            $base64 =  convertImageToBase64($imagePath);
            return $base64;
        }

        return null;
    }

    public function getCurrentSensorData(int $patient_id)
    {
        $patient = $this->patientModel::find($patient_id);
        $deviceId = $patient->userDevice()->get(['id']);
        $pulseOximetry = $this->pulseOximetry::find($deviceId);
        return $pulseOximetry ? $pulseOximetry : null;
    }

    public function getPatientLocation(int $patient_id)
    {
        $result =  $this->patientModel::find($patient_id)->get(['latitude', 'longitude']);
        return $result ? $result : null;
    }
}
