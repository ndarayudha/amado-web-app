<?php

namespace App\Services\HardwareService\Implement;

use App\Models\Device\UserDevice;
use App\Models\Monitoring\Monitoring;
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


    public function getJumlahMonitoring($serial_number){
        $userDeviceId = UserDevice::where('serial_number', $serial_number)->first()->patient_id;
        $jumlah_pengukuran = Monitoring::where('patient_id', $userDeviceId)->first()->jumlah_pengukuran;

        return $jumlah_pengukuran;
    }


    public function storeSensorData(Request $data)
    {

        $sensorData = $data->except('serial_number');
        $backupExist = $data->has('backup');

        $jumlah_pengukuran = $this->getJumlahMonitoring($data->serial_number);

        $serialNumberDevice = $data->serial_number;


        // cek apakah status device aktif
        $deviceStatus = $this->repositoryOximeter->getDeviceStatus($serialNumberDevice);


        if ($backupExist && $deviceStatus === DEVICE_ACTIVATED) {
            // simpan data sensor
            $result = $this->repositoryOximeter->storeTxt($serialNumberDevice, $sensorData);
            return $result;
        } else if ($sensorData !== null && $deviceStatus === DEVICE_ACTIVATED) {
            $result = $this->repositoryOximeter->store($sensorData, $serialNumberDevice, $jumlah_pengukuran);
            return $result;
        }

        return false;
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
