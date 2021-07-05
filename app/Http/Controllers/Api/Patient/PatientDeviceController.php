<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DeviceService\Implement\PatientHardwareService;
use Exception;

class PatientDeviceController extends Controller
{
    protected $patientHardwareService;


    public function __construct(PatientHardwareService $hardware)
    {
        $this->patientHardwareService = $hardware;
    }


    public function savePatientDevice(Request $request)
    {

        try {
            $hardwareDeviceStored = $this->patientHardwareService->storeDevice($request);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'device berhasil ditambahkan',
                'device' => $hardwareDeviceStored->serial_number,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'gagal',
                'message' => $e
            ]);
        }
    }

    public function getSerialNmber(Request $request)
    {
        $serialNumber = $this->patientHardwareService->getSerialNumber($request);

        if ($serialNumber !== "") {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'serial_number' => $serialNumber,
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'device belum terdaftar',
        ]);
    }

    public function enableDevice(Request $request)
    {

        $deviceEnabled = $this->patientHardwareService->enableDevice($request);

        if ($deviceEnabled === 1) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'device berhasil diaktifkan',
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'device gagal diaktifkan'
        ]);
    }

    public function disableDevice(Request $request)
    {

        $deviceDisabled = $this->patientHardwareService->disableDevice($request);

        if ($deviceDisabled === 0) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'device berhasil dinonaktifkan',
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'device gagal dinonaktifkan'
        ]);
    }
}
