<?php

namespace App\Repositories\HardwareRepository\Implement;

use App\Models\Device\UserDevice;
use App\Repositories\HardwareRepository\HardwareRepository;
use Illuminate\Database\Eloquent\Collection;

class PulseOximetryRepository implements HardwareRepository
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

        // insert data
        $patientDevice->pulseOximetries()->create($data);

        return $patientDevice;
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
