<?php

namespace App\Repositories\HardwareRepository;

interface HardwareRepository{
    function store($data, $serial_number,$jumlah_pengukuran);
    function getMeasurements($serial_number);
    function getDeviceStatus($serial_number);
    function getDevice($serial_number);
}