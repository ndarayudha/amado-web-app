<?php

namespace App\Repositories\DeviceRepository\Implement;


use App\Models\Patient\Patient;
use App\Models\Device\UserDevice;
use App\Repositories\DeviceRepository\DeviceOperationRepository;
use App\Repositories\DeviceRepository\DeviceRepository;


class PatientHardwareRepository implements
    DeviceRepository,
    DeviceOperationRepository
{

    public function saveDevice($patientId, $serialNumber): UserDevice
    {

        $patient = Patient::find($patientId);

        $patient->userDevice()->create([
            'serial_number' => $serialNumber
        ]);

        return $patient->userDevice;
    }


    public function getSerialNumber($patient_id)
    {
        return Patient::find($patient_id)->userDevice()->first()->serial_number;
    }


    public function getUserDeviceId($patient_id)
    {
        return Patient::find($patient_id)->userDevice()->first()->id;
    }


    public function updateDevice()
    {
        // TODO : Update Device
    }


    public function deleteDevice()
    {
        // TODO : Delete Device
    }


    public function on($patientId, $status)
    {
        $patient = Patient::find($patientId);

        $patient->userDevice()->update([
            'status' => $status
        ]);

        return $patient->userDevice->status;
    }


    public function off($patientId, $status)
    {
        $patient = Patient::find($patientId);

        $patient->userDevice()->update([
            'status' => $status
        ]);

        return $patient->userDevice->status;
    }
}
