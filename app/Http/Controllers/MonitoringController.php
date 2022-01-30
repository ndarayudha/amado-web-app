<?php

namespace App\Http\Controllers;

use App\Models\CloseContact\CloseContact;
use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Patient\Patient;
use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'data' => $result[0]
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

    // * Notification
    public function getPatientConfirmNotification(Request $request){

        $doctorHasBeenAuthenticated = Auth::guard('doctor-api')->user();
        $result = $this->patientMonitoringRepo->getPatientConfirm($doctorHasBeenAuthenticated->id);

        if ($result !== null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'notifications' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'belum ada notifikasi'
        ]);
    }

    public function readNotification(Request $request){

        $doctorHasBeenAuthenticated = Auth::guard('doctor-api')->user();
        $result = $this->patientMonitoringRepo->readNotification($doctorHasBeenAuthenticated->id, $request->notification_id);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => "notifikasi $request->notification_id telah di read"
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'notifikasi tidak ada / sudah dibaca'
        ]);
    }

    public function getCountModel(){
        $patients = Patient::all()->count();
        $kontak_erat = CloseContact::all()->count();
        $rekam_medis = MedicalRecord::all()->count();

        $statistik = [
            'total_pasien' => $patients,
            'total_kontak_erat' => $kontak_erat,
            'total_rekam_medis' => $rekam_medis,
        ];  

        return response()->json([
            'code' => 200,
            'counts' => $statistik
        ]);
    }

    public function getCurrentPatient(){
        $patients = Patient::latest()->get(['id', 'name', 'alamat', 'tanggal_lahir', 'created_at']);

        return response()->json([
            'code' => 200,
            'patients' => $patients
        ]);
    }
}
