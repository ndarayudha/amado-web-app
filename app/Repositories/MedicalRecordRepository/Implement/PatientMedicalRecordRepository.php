<?php

namespace App\Repositories\MedicalRecordRepository\Implement;

use App\Models\Device\Device;
use App\Models\Device\UserDevice;
use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Patient\Patient;
use App\Repositories\MedicalRecordRepository\IMedicalRecordRepository;


class PatientMedicalRecordRepository implements IMedicalRecordRepository
{

    private Patient $patient;
    private Device $device;
    private MedicalRecord $medicalRecord;


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

        $patientRecord = array(
            $patientData,
            $patientMonitoringLocation,
            $patientCloseContact,
            $patientDeviceType,
            $patientMedicalRecord,
        );

        // dd($patientRecord);

        return $patientRecord;
    }


    public function getMonitoringResult($patient_id): array
    {
        $patientMedicalRecord = $this->medicalRecord::where('patient_id', $patient_id)->get()->all();

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


    public function delete($id)
    {
        return MedicalRecord::where('id', $id)->delete();
    }

    // public function delete($patient_id)
    // {
    //     return MedicalRecord::where('patient_id', $patient_id)->delete();
    // }
}
