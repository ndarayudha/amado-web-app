<?php

namespace App\Repositories\MedicalRecordRepository\Implement;

use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Patient\Patient;
use App\Repositories\MedicalRecordRepository\IMedicalRecordWeb;
use Illuminate\Support\Facades\DB;


class PatientMedicalRecordWebRepository implements IMedicalRecordWeb
{

    protected MedicalRecord $medicalRecord;
    protected Patient $patient;

    public function __construct(MedicalRecord $medicalRecord, Patient $patient)
    {
        $this->medicalRecord = $medicalRecord;
        $this->patient = $patient;
    }

    public function get(): object
    {
        return DB::table('patients')
            ->join('medical_records', 'patients.id', '=', 'medical_records.patient_id')
            ->select('patients.id', 'patients.name', 'medical_records.averrage_spo2', 'medical_records.status', 'medical_records.updated_at')
            ->get();
    }

    public function getById($patient_id): object
    {
        return $this->medicalRecord->findOrFail($patient_id);
    }

    public function search(string $code = null): object
    {
        return $this->medicalRecord->whereStatus(0)->where('code', 'like', '%' . $code . '%')->get(['id', 'code as text', 'title']);
    }

    public function getMedicalRecord(): object
    {
        return $this->medicalRecord->get();
    }
}
