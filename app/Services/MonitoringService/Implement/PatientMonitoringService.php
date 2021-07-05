<?php

namespace App\Services\MonitoringService\Implement;

use App\Repositories\DeviceRepository\Implement\PatientHardwareRepository;
use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;
use App\Services\MedicalRecordService\Implement\PatientMedicalRecordService;
use App\Services\MonitoringService\MonitoringService;
use App\Services\HardwareService\Implement\PulseOximetryService;
use Illuminate\Support\Facades\Auth;

class PatientMonitoringService implements MonitoringService
{

    protected PatientMonitoringRepository $monitoringRepo;
    protected PatientMedicalRecordService $medicalRecordService;
    protected PatientHardwareRepository $hardwareRepo;
    protected PulseOximetryService $pulseService;


    public function __construct(
        PatientMonitoringRepository $monitoringRepo,
        PatientMedicalRecordService $medicalRecordService,
        PatientHardwareRepository $hardwareRepo,
        PulseOximetryService $pulseService
    ) {
        $this->monitoringRepo = $monitoringRepo;
        $this->medicalRecordService = $medicalRecordService;
        $this->hardwareRepo = $hardwareRepo;
        $this->pulseService = $pulseService;
    }


    public function updateTotalMonitoring(int $patient_id, int $total)
    {
        $totalBeforeMonitoring = $this->monitoringRepo->get($patient_id);
        $totalAfterMonitoring = 0;

        if ($totalBeforeMonitoring < 3) {

            $currentUpdateMonitoring = $totalBeforeMonitoring + $total;
            $this->monitoringRepo->update($patient_id, $currentUpdateMonitoring);
            $totalAfterMonitoring = $this->monitoringRepo->get($patient_id);

            if ($totalAfterMonitoring === 3) {
                // get patient device id
                $serial_number = $this->getSerialNumber($patient_id);
                // calculate sensor data
                $resultSensor = $this->calculateAverrageData($serial_number, $this->pulseService);
                // create patient medical record
                $this->medicalRecordService->createMedicalRecord($patient_id, $resultSensor);
                // roll back to 0 value, because max monitoring is 3
                $this->monitoringRepo->update($patient_id, 0);
            }
        }
    }


    public function initialMonitoring(int $patient_id, int $total)
    {
        $this->monitoringRepo->create($patient_id, $total);
    }


    public function resetMonitoring($patient_id, $reset)
    {
        $this->monitoringRepo->update($patient_id, $reset);
    }


    /**
     * ! SEMENTARA
     */
    public function getSerialNumber($patient_id)
    {
        return $this->hardwareRepo->getSerialNumber($patient_id);
    }


    public function getUserDeviceId($patient_id)
    {
        return $this->hardwareRepo->getUserDeviceId($patient_id);
    }


    public function calculateAverrageData($serial_number, PulseOximetryService $hardwareService)
    {
        $allSensorData = $hardwareService->getSensorData($serial_number)->pluck('spo2')->all();
        $totalLengthData = count($allSensorData);
        $sumTotalData = array_sum($allSensorData);
        $result = $sumTotalData / $totalLengthData;

        return $result;
    }


    /**
     * * Get patient has been authenticated
     */
    public function getCurrentPatientAuthenticated()
    {
        return Auth::guard('patientapi')->user();
    }
}
