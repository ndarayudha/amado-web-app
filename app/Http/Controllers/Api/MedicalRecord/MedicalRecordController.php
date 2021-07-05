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
            'patient' => $result['user'],
            'monitoring_location' => $result['monitoring_location'],
            'close_contacts' => $result['close_contact'],
            'device_type' => $result['device_type'],
            'monitoring_result' => $result['monitoring_result']
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
