<?php

namespace App\Services\HardwareService\Implement;

use App\Models\Device\UserDevice;
use App\Repositories\HardwareRepository\Implement\PulseOximetryRepository;
use App\Services\HardwareService\HardwareService;
use Illuminate\Http\Request;

const DEVICE_ACTIVATED = 1;

class PulseOximetryService implements HardwareService
{

    /**
     * * Instansiasi repo
     */
    protected $repositoryOximeter;
    protected $userDevice;


    public function __construct(PulseOximetryRepository $repo, UserDevice $device)
    {
        $this->repositoryOximeter = $repo;
        $this->userDevice = $device;
    }


    public function storeSensorData(Request $data)
    {

        $sensorData = $data->except('serial_number');
        $serialNumberDevice = $data->serial_number;

        // cek apakah status device aktif
        $deviceStatus = $this->repositoryOximeter->getDeviceStatus($serialNumberDevice);

        if ($sensorData != null && $deviceStatus === DEVICE_ACTIVATED) {
            // simpan data sensor
            $result = $this->repositoryOximeter->store($sensorData, $serialNumberDevice);
            return $result;
        }

        return;
    }

    public function getSensorData($serial_number)
    {
        // cek apakah device ada
        $isDeviceExist = $this->repositoryOximeter->getDevice($serial_number);

        if ($isDeviceExist) {
            $sensorData = $this->repositoryOximeter->getMeasurements($serial_number);
            if (count($sensorData) == 0) {
                return false;
            }
            return $sensorData;
        }

        return $isDeviceExist;
    }
}
