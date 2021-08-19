<?php

namespace App\Http\Controllers;

use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    private PatientMonitoringRepository $patientMonitoringRepo;

    public function __construct(PatientMonitoringRepository $patientMonitoringRepo)
    {
        $this->patientMonitoringRepo = $patientMonitoringRepo;
    }


    public function getPatientMonitoringTotalAndCurrentTime(Request $request)
    {
        $result = $this->patientMonitoringRepo->getPatientMonitoring($request->id);

        if ($result !== null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'data' => [
                    'patientId' => $result[0]->patient_id,
                    'totalMonitoring' => $result[0]->total_monitoring,
                    'currentMonitoring' => date_format($result[0]->updated_at, 'Y/m/d H:i:s')
                ]
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'belum melakukan monitoring sama sekali'
        ]);
    }


    public function getPatientPhoto(Request $request)
    {
        $base64Format = $this->patientMonitoringRepo->getPhoto($request->id);

        if ($base64Format != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => $base64Format
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'tidak ada gambar'
        ]);
    }


    public function getCurrentSpo2AndBpm(Request $request)
    {
        $result = $this->patientMonitoringRepo->getCurrentSensorData($request->id);

        if ($result != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'data' => [
                    'deviceId' => $result[0]->id,
                    'spo2' => $result[0]->spo2,
                    'bpm' => $result[0]->bpm,
                    'latitude' => $result[0]->latitude,
                    'longitude ' => $result[0]->longitude,
                ]
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'device tidak ada'
        ]);
    }

    public function getPatientLocationById(Request $request)
    {
        $result = $this->patientMonitoringRepo->getPatientLocation($request->id);

        if ($result != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'coordinat' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'pasien belum mengupdate lokasinya'
        ]);
    }
}
