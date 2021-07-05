<?php

namespace App\Repositories\HardwareRepository;

interface HardwareRepository{
    function store($data, $serial_number);
    function getMeasurements($serial_number);
    function getDeviceStatus($serial_number);
    function getDevice($serial_number);
}