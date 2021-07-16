<?php

namespace App\Http\Controllers\Api\MedicalRecord;

use App\Http\Controllers\Controller;
use App\Services\MedicalRecordService\Implement\PatientMedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{

    protected PatientMedicalRecordService $medicalRecord;

    public function __construct(PatientMedicalRecordService $medicalRecord)
    {
        $this->medicalRecord = $medicalRecord;
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
}
