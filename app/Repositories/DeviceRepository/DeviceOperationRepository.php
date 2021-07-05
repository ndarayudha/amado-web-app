<?php

namespace App\Repositories\DeviceRepository;

interface DeviceOperationRepository {
    function on($patientId, $status);
    function off($patientId, $status);
}