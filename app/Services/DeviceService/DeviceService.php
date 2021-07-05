<?php

namespace App\Services\DeviceService;

use App\Services\HardwareService\HardwareService;

interface DeviceService
{
    function storeDevice($request);
    function updateDevice();
    function deleteDevice();
    // function calculateAverrageData($serial_number, HardwareService $hardwareService);
}
