<?php

namespace App\Services\MedicalRecordService\Implement;


use App\Repositories\MedicalRecordRepository\Implement\PatientMedicalRecordRepository;
use App\Services\MedicalRecordService\IMedicalRecordService;

class PatientMedicalRecordService implements IMedicalRecordService
{

    protected PatientMedicalRecordRepository $medicalRecordRepo;


    public function __construct(PatientMedicalRecordRepository $repo)
    {
        $this->medicalRecordRepo = $repo;
    }


    public function createMedicalRecord($patient_id, $resultSensor)
    {
        $status = $this->checkDiagnose($resultSensor);
        $recomendation = $this->giveRecomendation($status);

        $this->medicalRecordRepo->save($patient_id, $resultSensor, $status, $recomendation);
    }


    // public function getMedicalRecord($patient_id)
    // {
    //     $patientRecord = $this->medicalRecordRepo->getAll($patient_id);
    //     return $patientRecord;
    // }


    public function getMedicalRecord($patient_id)
    {
        $closeContacts = $this->medicalRecordRepo->getAllPatient($patient_id);

        return $closeContacts;
    }


    public function getMonitoringResult($patient_id)
    {
        $monitoringResult = $this->medicalRecordRepo->getMonitoringResult($patient_id);
        return $monitoringResult;
    }


    public function updateMedicalRecord($patient_id)
    {
    }


    public function checkDiagnose($resultSensor): string
    {
        $rules = [
            'normal' => range(97, 100),
            'sedang' => range(95, 97),
            'beresiko' => range(60, 94)
        ];

        foreach ($rules as $status => $range) {
            if (in_array($resultSensor, $range)) {
                return $status;
                break;
            }
        }
    }


    public function giveRecomendation($diagnose): string
    {
        $rules = [
            'normal' => 'tetap jaga kesehatan anda dengan patuhi protokol kesehatan',
            'sedang' => 'hindari melakukan aktivitas yang berlebihan',
            'beresiko' => 'segera kunjungi rumah sakit terdekat untuk mendapatkan perawatan lebih lanjut'
        ];

        foreach ($rules as $status => $recomendation) {
            if ($diagnose === $status) {
                return $recomendation;
                break;
            }
        }
    }
}
