<?php

namespace App\Services\MonitoringService;

use Illuminate\Http\Request;

interface MonitoringService
{
    function updateTotalMonitoring(int $patient_id, int $total);
    function initialMonitoring(int $patient_id, int $total);
}
