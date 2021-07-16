<?php

namespace App\Repositories\MedicalRecordRepository\Implement;

use App\Models\Device\Device;
use App\Models\Device\UserDevice;
use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Patient\Patient;
use App\Repositories\MedicalRecordRepository\IMedicalRecordRepository;
use Carbon\Carbon;

class PatientMedicalRecordRepository implements IMedicalRecordRepository
{

    private Patient $patient;
    private Device $device;
    private MedicalRecord $medicalRecord;
    private UserDevice $userDevice;

    public function __construct(Patient $model, MedicalRecord $medicalRecord, Device $device, UserDevice $userDevice)
    {
        $this->patient = $model;
        $this->medicalRecord = $medicalRecord;
        $this->device = $device;
        $this->userDevice = $userDevice;
    }

    public function getAll($patient_id): array
    {
        $patient = $this->patient::find($patient_id);

        $patientData = collect($patient)->only(['id', 'name', 'photo', 'phone', 'email', 'jenis_kelamin', 'tanggal_lahir', 'alamat'])->toArray();
        $patientMonitoringLocation = collect($patient)->only(['latitude', 'longitude'])->toArray();
        $patientCloseContact = $patient->closeContacts()->get()->toArray();
        $patientDeviceId = $patient->userDevice()->get()->pluck('device_id')->toArray()[0];
        $patientDeviceType = $this->device::find($patientDeviceId)->name;
        $patientMedicalRecord = $this->getMonitoringResult($patient_id);

        $patientRecord = array(
            'user' => $patientData,
            'monitoring_location' => $patientMonitoringLocation,
            'close_contact' => $patientCloseContact,
            'device_type' => $patientDeviceType,
            'monitoring_result' => $patientMedicalRecord
        );

        return $patientRecord;
    }


    public function getAllPatient($patient_id): array
    {
        $patient = $this->patient::find($patient_id);


        $patientData = collect($patient)->only(['id', 'name', 'photo', 'phone', 'email', 'jenis_kelamin', 'tanggal_lahir', 'alamat'])->toArray();
        $patientMonitoringLocation = collect($patient)->only(['latitude', 'longitude'])->toArray();
        $patientCloseContact = $patient->closeContacts()->get()->toArray();
        $patientDeviceId = $patient->userDevice()->get()->pluck('device_id')->toArray()[0];
        $patientDeviceType = $this->device::find($patientDeviceId)->name;
        $patientMedicalRecord = $this->getMonitoringResult($patient_id);
        $patientSpo2Data = $this->userDevice::find($patientDeviceId)->pulseOximetries()->pluck('spo2')->toArray();

        $patientRecord = array(
            $patientData,
            $patientMonitoringLocation,
            $patientCloseContact,
            $patientDeviceType,
            $patientMedicalRecord,
            $patientSpo2Data
        );

        return $patientRecord;
    }


    public function getMonitoringResult($patient_id): array
    {
        $patientMedicalRecord = $this->medicalRecord::where('patient_id', $patient_id)->get()->last()->only(['averrage_spo2', 'averrage_bpm', 'status', 'recomendation', 'created_at']);

        $medicalRecordDate = $patientMedicalRecord['created_at']->format('Y-m-d H:i:s', 'Asia/Jakarta');
        
        $patientMedicalRecord['created_at'] = $medicalRecordDate;
        
        return $patientMedicalRecord;
    }



    public function save($patient_id, $avgSpo2, $avgBpm, $status, $recomendation)
    {
        $patient = $this->patient::find($patient_id);
        $patient->medicalRecord()->create([
            'averrage_spo2' => $avgSpo2,
            'averrage_bpm' => $avgBpm,
            'status' => $status,
            'recomendation' => $recomendation
        ]);
    }


    public function update($patient_id)
    {
    }
}
