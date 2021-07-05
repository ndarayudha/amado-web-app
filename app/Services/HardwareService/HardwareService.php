<?php

namespace App\Services\HardwareService;

use Illuminate\Http\Request;

interface HardwareService {
    function storeSensorData(Request $data);
    function getSensorData(Request $request);
}