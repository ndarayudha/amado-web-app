<?php

namespace App\Services\DeviceService;

interface DeviceOperationService{
    function enableDevice($request);
    function disableDevice($request);
}