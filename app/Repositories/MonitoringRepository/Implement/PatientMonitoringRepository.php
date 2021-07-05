<?php

namespace App\Repositories\MonitoringRepository\Implement;


use App\Models\Patient\Patient;
use App\Repositories\MonitoringRepository\MonitoringRepository;
use Illuminate\Support\Facades\Log;

class PatientMonitoringRepository implements MonitoringRepository
{
    protected Patient $patientModel;

    public function __construct(Patient $model)
    {
        $this->patientModel = $model;
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
}
