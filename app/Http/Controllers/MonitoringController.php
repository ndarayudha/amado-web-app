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
                'data' => $result
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

    public function getMedicalRecords()
    {
        $result = $this->patientMonitoringRepo->getAllRecord();

        if ($result != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'records' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'pasien belum mempunyai rekam medis'
        ]);
    }


    // * Medical Record Detail
    public function getDetailMedicalRecordBio(Request $request)
    {
        $result = $this->patientMonitoringRepo->getPatientBioRecord($request->id);

        if ($result != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'result' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'pasien belum mempunyai rekam medis'
        ]);
    }

    public function getOximetryData(Request $request)
    {
        $result = $this->patientMonitoringRepo->getPulseOximeterData($request->id);

        if ($result != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'data' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'pasien belum melakukan monitoring dengan pulse oximetry'
        ]);
    }

    public function getPatientCloseContactById(Request $request)
    {
        $result = $this->patientMonitoringRepo->getPatientCloseContact($request->id);

        if ($result != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'data' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'pasien belum mempunyai rekam medis'
        ]);
    }


    public function deletePatientMedicalRecordById(Request $request)
    {
        $result = $this->patientMonitoringRepo->deleteMedicalRecordById($request->id);

        if ($result === 1) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'rekam medis berhasil di hapus'
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'rekam medis gagal di hapus'
        ]);
    }

    public function insertRiwayatPenanganan(Request $request)
    {
        $result = $this->patientMonitoringRepo->saveRiwayatPenanganan($request);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'penanganan berhasil diberikan'
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'penanganan gagal diberikan'
        ]);
    }

    public function tambahKapasitasOksigenRumahSakit(Request $request)
    {
        $result = $this->patientMonitoringRepo->tambahKapasitasOksigen($request);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'kapasitas oksigen berhasil ditambah'
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'kapasitas oksigen gagal ditambahkan'
        ]);
    }


    public function kurangiKapasitasOksigenRumahSakit(Request $request)
    {
        $result = $this->patientMonitoringRepo->kurangiKapasitasOksigen($request);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'kapasitas oksigen berhasil dikurangi'
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'kapasitas oksigen gagal dikurang'
        ]);
    }

    public function getCurrentOksigen(Request $request)
    {
        $result = $this->patientMonitoringRepo->getKapasitasOksigen($request->id);

        if ($result !== null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'data' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'tidak ada data oksigen'
        ]);
    }
}
