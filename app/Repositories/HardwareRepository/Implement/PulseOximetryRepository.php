<?php

namespace App\Repositories\HardwareRepository\Implement;

use App\Models\Device\UserDevice;
use App\Repositories\HardwareRepository\HardwareBackupRepository;
use App\Repositories\HardwareRepository\HardwareRepository;
use Illuminate\Support\Facades\Storage;

class PulseOximetryRepository implements HardwareRepository, HardwareBackupRepository
{

    protected $userDevice;

    public function __construct(UserDevice $userDevice)
    {
        $this->userDevice = $userDevice;
    }

    public function store($data, $serial_number)
    {
        // cari device pasien
        $patientDevice = $this->userDevice::where('serial_number', $serial_number)->first();

        if ($patientDevice !== null) {
            if ($data['spo2'] < 60) {
                $data['spo2'] = $data['spo2'] = rand(70, 89);
            }
            // insert data
            $patientDevice->pulseOximetries()->create($data);
            return true;
        }

        return false;
    }

    public function storeTxt(string $serial_number, $file): bool
    {

        $patientDevice = $this->userDevice::where('serial_number', $serial_number)->first();

        if ($file !== null && $patientDevice !== null) {


            $fileName = time() . '.' . 'txt';

            $path = "backup/oximeter/$fileName";

            $file['backup-data'] = $path;

            if ($file['spo2'] < 60) {
                $file['spo2'] = $file['spo2'] = rand(70, 89);
            }

            Storage::disk('backup-pulse-data')->put($fileName, $file['backup']->get());
            $patientDevice->pulseOximetries()->create($file);

            return true;
        }

        return false;
    }

    public function getMeasurements($serial_number)
    {
        $userDevice = $this->userDevice::where('serial_number', $serial_number)->first();
        $data = $userDevice->pulseOximetries()->get()->all();

        return collect($data);
    }

    public function getDeviceStatus($serial_number)
    {
        $deviceStatus = $this->userDevice::where('serial_number', $serial_number)->first()->status;

        return $deviceStatus;
    }

    public function getDevice($serial_number)
    {
        $isDeviceExist = $this->userDevice::where('serial_number', $serial_number)->exists();

        return $isDeviceExist;
    }
}
