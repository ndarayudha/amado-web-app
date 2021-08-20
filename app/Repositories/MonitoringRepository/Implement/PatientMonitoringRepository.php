<?php

namespace App\Repositories\MonitoringRepository\Implement;

use App\Models\CloseContact\CloseContact;
use App\Models\Hardware\PulseOximetry;
use App\Models\MedicalRecord\MedicalRecord;
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
    private MedicalRecord $medicalRecord;
    private CloseContact $closeContact;

    public function __construct(
        Patient $model,
        Monitoring $monitoring,
        PatientRepository $patientRepository,
        PulseOximetry $pulseOximetry,
        MedicalRecord $medicalRecord,
        CloseContact $closeContact
    ) {
        $this->patientModel = $model;
        $this->monitoring = $monitoring;
        $this->patientRepository = $patientRepository;
        $this->pulseOximetry = $pulseOximetry;
        $this->medicalRecord = $medicalRecord;
        $this->closeContact = $closeContact;
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
        $pulseOximetry = $this->pulseOximetry::where('user_device_id', $deviceId[0]['id'])->get()->last();
        return $pulseOximetry ? $pulseOximetry : null;
    }

    public function getPatientLocation(int $patient_id)
    {
        $patient =  $this->patientModel::where('id', $patient_id);
        $result = $patient->get(['latitude', 'longitude']);
        return $result ? $result : null;
    }


    public function getAllRecord()
    {
        $patients = $this->patientModel->get(['id', 'name', 'tanggal_lahir', 'alamat'])->toArray();
        $medicalRecords = $this->medicalRecord->get(['id', 'patient_id', 'averrage_spo2', 'averrage_bpm', 'konfirmasi', 'created_at', 'updated_at'])->toArray();

        foreach ($patients as $key => $value) {
            $medicalRecord = [];
            foreach ($medicalRecords as $index => $nilai) {
                if ($patients[$key]['id'] === $medicalRecords[$index]['patient_id']) {
                    array_push($medicalRecord, $medicalRecords[$index]);
                }
            }
            $patients[$key]['medicalRecord'] = $medicalRecord;
        }

        return $patients ? $patients : null;
    }

    // * Medical Record Detail
    public function getPatientBioRecord(int $patient_id)
    {
        $patientIdBasedOnMedicalRecordId = $this->medicalRecord::where('id', $patient_id)->get(['patient_id', 'averrage_spo2', 'averrage_bpm', 'status'])->toArray();
        $patient = $this->patientModel::where('id', $patientIdBasedOnMedicalRecordId[0]['patient_id'])->get(['name', 'tanggal_lahir', 'phone', 'alamat'])->toArray();

        $photo = $this->getPhoto($patientIdBasedOnMedicalRecordId[0]['patient_id']);

        $patient[0]['spo2'] = $patientIdBasedOnMedicalRecordId[0]['averrage_spo2'];
        $patient[0]['bpm'] = $patientIdBasedOnMedicalRecordId[0]['averrage_bpm'];
        $patient[0]['status'] = $patientIdBasedOnMedicalRecordId[0]['status'];
        $patient[0]['photo'] = $photo;

        return $patient ? $patient : null;
    }

    public function getPulseOximeterData(int $patient_id)
    {
        $patientIdBasedOnMedicalRecordId = $this->medicalRecord::where('id', $patient_id)->get('patient_id')->toArray();
        $patient = $this->patientModel::find($patientIdBasedOnMedicalRecordId[0]['patient_id']);
        $deviceId = $patient->userDevice()->get(['id'])[0]['id'];
        $dataSensor = $this->pulseOximetry::where('user_device_id', $deviceId)->get();

        return $dataSensor ? $dataSensor : null;
    }

    public function getPatientCloseContact(int $medicalRecordId)
    {
        $patientIdBasedOnMedicalRecordId = $this->medicalRecord::where('id', $medicalRecordId)->get('patient_id')->toArray();
        $patient = $this->patientModel::find($patientIdBasedOnMedicalRecordId[0]['patient_id']);
        $result = $this->closeContact::where('patient_id', $patient['id'])->get();
        return $result ? $result : null;
    }

    public function deleteMedicalRecordById(int $medicalRecordId)
    {
        return $this->medicalRecord::where('id', $medicalRecordId)->delete();
    }
}
