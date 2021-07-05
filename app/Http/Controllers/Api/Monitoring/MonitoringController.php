<?php

namespace App\Http\Controllers\Api\Monitoring;

use App\Http\Controllers\Controller;
use App\Services\MonitoringService\Implement\PatientMonitoringService;
use Exception;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{

    protected PatientMonitoringService $monitoringService;

    public function __construct(PatientMonitoringService $service)
    {
        $this->monitoringService = $service;
    }

    public function testUpdateTotalMonitoring(Request $request)
    {
        try {
            $this->monitoringService->updateTotalMonitoring($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ]);
        }
    }
}
