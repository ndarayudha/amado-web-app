<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Repositories\MedicalRecordRepository\Implement\PatientMedicalRecordRepository;
use App\Services\MedicalRecordService\Implement\PatientMedicalRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{

    protected PatientMedicalRecordService $medicalRecord;
    private PatientMedicalRecordRepository $medicalRecordRepo;

    public function __construct(PatientMedicalRecordService $medicalRecord, PatientMedicalRecordRepository $medicalRecordRepo)
    {
        $this->medicalRecord = $medicalRecord;
        $this->medicalRecordRepo = $medicalRecordRepo;
    }


    public function getMedicalRecord(Request $request)
    {
        $result = $this->medicalRecord->getMedicalRecord($request->patient_id);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'patient' => $result[0],
            'monitoring_location' => $result[1],
            'close_contacts' => $result[2],
            'device_type' => $result[3],
            'monitoring_result' => $result[4]
        ]);
    }


    public function getMonitoringResult(Request $request)
    {
        $result = $this->medicalRecord->getMonitoringResult($request->patient_id);

        if ($result !== null) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'monitoring_result' => $result
            ]);
        }
        return response()->json([
            'code' => 400,
            'status' => 'failed',
            'monitoring_result' => 'belum melakuan monitoring'
        ]);
    }


    public function deleteMedicalRecord(Request $request)
    {
        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();

        $result = $this->medicalRecordRepo->delete($patientHasBeenAuthenticated->id);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'rekam medis berhasil di hapus'
            ]);
        }
        return response()->json([
            'code' => 400,
            'status' => 'failed',
            'message' => 'rekam medis tidak ada'
        ]);
    }
}
