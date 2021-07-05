<?php

namespace App\Services\DeviceService\Implement;

use App\Repositories\DeviceRepository\Implement\PatientHardwareRepository;
use App\Services\DeviceService\DeviceOperationService;
use App\Services\DeviceService\DeviceService;
use App\Services\MonitoringService\Implement\PatientMonitoringService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;

class PatientHardwareService implements DeviceService, DeviceOperationService
{

    protected PatientHardwareRepository $hardwareRepository;
    protected PatientMonitoringService $monitoringService;
    protected PatientMonitoringRepository $monitoringRepo;


    public function __construct(
        PatientHardwareRepository $hardware,
        PatientMonitoringService $service,
        PatientMonitoringRepository $monitoringRepo
    ) {
        $this->hardwareRepository = $hardware;
        $this->monitoringService = $service;
        $this->monitoringRepo = $monitoringRepo;
    }



    public function storeDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $hardwareDeviceStored = $this->hardwareRepository->saveDevice($patientHasBeenAuthenticated->id, $request->serial_number);

        // initialiizing 0 times monitoring
        $this->monitoringService->initialMonitoring($patientHasBeenAuthenticated->id, 0);

        return $hardwareDeviceStored;
    }



    public function updateDevice()
    {
    }



    public function deleteDevice()
    {
    }


    public function enableDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $deviceStatus = $this->hardwareRepository->on($patientHasBeenAuthenticated->id, $request->status);

        Log::info("Enabled Device for patient id {$patientHasBeenAuthenticated->id}");

        return $deviceStatus;
    }



    public function disableDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $deviceStatus = $this->hardwareRepository->off($patientHasBeenAuthenticated->id, $request->status);
        Log::info("Disabled device for patient id {$patientHasBeenAuthenticated->id}");

        $currentMonitoring = $this->monitoringRepo->get($patientHasBeenAuthenticated->id);

        if ($currentMonitoring === 3) {
            $this->monitoringService->updateTotalMonitoring($patientHasBeenAuthenticated->id, 1);
            $this->monitoringService->resetMonitoring($patientHasBeenAuthenticated->id, 0);
        } else {
            $this->monitoringService->updateTotalMonitoring($patientHasBeenAuthenticated->id, 1);
        }
        // upgrade monitoring value to + 1

        return $deviceStatus;
    }


    public function getSerialNumber($request)
    {
        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $serial_number = $this->hardwareRepository->getSerialNumber($patientHasBeenAuthenticated->id);
        return $serial_number;
    }


    // public function calculateAverrageData($serial_number, HardwareService $hardwareService)
    // {
    //     $sensorData = $hardwareService->getSensorData($serial_number);
    //     return $sensorData;
    // }
}
