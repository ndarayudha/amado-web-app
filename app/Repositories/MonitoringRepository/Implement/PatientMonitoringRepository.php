<?php

namespace App\Repositories\MonitoringRepository\Implement;

use App\Mail\PenangananMail;
use App\Models\CloseContact\CloseContact;
use App\Models\Doctor;
use App\Models\Hardware\PulseOximetry;
use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Monitoring\Monitoring;
use App\Models\Oksigen;
use App\Models\Patient\Patient;
use App\Models\RiwayatPenanganan;
use App\Models\RumahSakit;
use App\Repositories\MonitoringRepository\MonitoringRepository;
use App\Repositories\UserRepository\Implement\PatientRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PatientMonitoringRepository implements MonitoringRepository
{
    protected Patient $patientModel;
    private Monitoring $monitoring;
    private PatientRepository $patientRepository;
    private PulseOximetry $pulseOximetry;
    private MedicalRecord $medicalRecord;
    private CloseContact $closeContact;
    private RiwayatPenanganan $riwayatPenanganan;
    private RumahSakit $rumahSakit;
    private Oksigen $oksigen;

    public function __construct(
        Patient $model,
        Monitoring $monitoring,
        PatientRepository $patientRepository,
        PulseOximetry $pulseOximetry,
        MedicalRecord $medicalRecord,
        CloseContact $closeContact,
        RiwayatPenanganan $riwayatPenanganan,
        RumahSakit $rumahSakit,
        Oksigen $oksigen
    ) {
        $this->patientModel = $model;
        $this->monitoring = $monitoring;
        $this->patientRepository = $patientRepository;
        $this->pulseOximetry = $pulseOximetry;
        $this->medicalRecord = $medicalRecord;
        $this->closeContact = $closeContact;
        $this->riwayatPenanganan = $riwayatPenanganan;
        $this->rumahSakit = $rumahSakit;
        $this->oksigen = $oksigen;
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
        $medicalRecords = $this->medicalRecord->get(['id', 'patient_id', 'averrage_spo2', 'averrage_bpm', 'url', 'konfirmasi', 'created_at', 'updated_at'])->toArray();

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
        $patient = $this->patientModel::where('id', $patientIdBasedOnMedicalRecordId[0]['patient_id'])->get(['name', 'tanggal_lahir', 'photo', 'phone', 'alamat', 'jenis_kelamin'])->toArray();
        $patient[0]['spo2'] = $patientIdBasedOnMedicalRecordId[0]['averrage_spo2'];
        $patient[0]['bpm'] = $patientIdBasedOnMedicalRecordId[0]['averrage_bpm'];
        $patient[0]['status'] = $patientIdBasedOnMedicalRecordId[0]['status'];
        

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

    public function saveRiwayatPenanganan(Request $penanganan): bool
    {
        $medicalRecord = $this->medicalRecord::find($penanganan->rekam_medis_id);

        $this->sendEmail($penanganan->all());

        try {
            if ($penanganan['oksigen'] !== null) {
                $this->riwayatPenanganan::create([
                    'ket_spo2' => $penanganan['spo2'],
                    'ket_bpm' => $penanganan['bpm'],
                    'diagnosa' => $penanganan['diagnosa'],
                    'tindak_lanjut' => $penanganan['tindakan'],
                    'tanggal_masuk' => $penanganan['tanggal_masuk'],
                    'tanggal_keluar' => $penanganan['tanggal_keluar'],
                    'penanganan' => "rawat inap dan diberikan tabung oksigen sejumlah" . $penanganan['oksigen'] . 'buah',
                    'saran' => $penanganan['saran']
                ]);

                // Kurangi Kapasitas oksigen

                // kurangi kapasitas ruangan
            } else {
                $this->riwayatPenanganan::create([
                    'ket_spo2' => $penanganan['spo2'],
                    'ket_bpm' => $penanganan['bpm'],
                    'diagnosa' => $penanganan['diagnosa'],
                    'tindak_lanjut' => $penanganan['tindakan'],
                    'saran' => $penanganan['saran']
                ]);
            }

            Log::info("medial Record $penanganan->rekam_medis_id");

            $medicalRecord->update([
                'konfirmasi' => 'Terkonfirmasi'
            ]);

            $currentRiwayatPenanganan = $this->riwayatPenanganan::find($penanganan->rekam_medis_id);
            $currentRiwayatPenanganan->medicalRecords()->attach($penanganan->rekam_medis_id);



            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public function sendEmail(array $data)
    {
        Mail::to('yudhayofan1@gmail.com')->send(new PenangananMail($data));

        return 'email telah dikirim';
    }

    public function tambahKapasitasOksigen(Request $request)
    {
        try {
            $rumahSakit = $this->rumahSakit::find($request->id);
            $oksigenId = $rumahSakit->oksigens()->get()->toArray()[0]['id'];
            $rsOksigen = $this->oksigen::where('id', $oksigenId);
            $currentOksigen = (int) $rsOksigen->get(['kapasitas_oksigen'])->toArray()[0]['kapasitas_oksigen'];

            $rsOksigen->update([
                'kapasitas_oksigen' => $currentOksigen + (int) $request->kapasitas
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public function kurangiKapasitasOksigen(Request $request)
    {
        try {
            $rumahSakit = $this->rumahSakit::find($request->id);
            $oksigenId = $rumahSakit->oksigens()->get()->toArray()[0]['id'];
            $rsOksigen = $this->oksigen::where('id', $oksigenId);
            $currentOksigen = (int) $rsOksigen->get(['kapasitas_oksigen'])->toArray()[0]['kapasitas_oksigen'];

            $rsOksigen->update([
                'kapasitas_oksigen' => $currentOksigen - (int) $request->kapasitas
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getKapasitasOksigen(int $rumah_sakit_id)
    {
        $rumahSakit = $this->rumahSakit::find($rumah_sakit_id);
        return $rumahSakit ? $rumahSakit->oksigens()->get() : null;
    }


    // * Notification
    public function getPatientConfirm(int $doctor_id){
        
        $doctor = Doctor::find($doctor_id);

        $notifications = [];
        foreach ($doctor->unreadNotifications as $notification) {
            array_push($notifications, $notification);
        }

        return $notifications;
    }

    public function readNotification(int $doctor_id, string $notification_id){
        $doctor = Doctor::find($doctor_id);

        $result = $doctor->unreadNotifications()->where('id', $notification_id)->update(['read_at' => now()]);

        return $result == 1 ? true : false;
    }
}
