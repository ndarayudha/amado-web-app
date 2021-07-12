<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HardwareService\Implement\PulseOximetryService;
use Exception;

const EXIST = false;

class PulseOximetryController extends Controller
{
    protected $oximetryService;

    public function __construct(PulseOximetryService $service)
    {
        $this->oximetryService = $service;
    }


    public function storeDataSensor(Request $request)
    {
        $result = $this->oximetryService->storeSensorData($request);

        try {
            if ($result) {
                return response()->json([
                    'message' => 'data berhasil di simpan'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ]);
        }
    }


    public function getDataSensor(Request $request)
    {

        $data = $this->oximetryService->getSensorData($request->serial_number);
        if ($data !== EXIST) {
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'Data kosong'
        ]);
    }
}
