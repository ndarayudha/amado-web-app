<?php

namespace App\Http\Controllers;

use App\Models\Hardware\PulseOximetry;
use App\Models\MedicalRecord\MedicalRecord;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function getSensorDataById(Request $request)
    {
        $sensor_data = PulseOximetry::where('id_pengukuran', $request->id)->get(['id_pengukuran', 'spo2', 'bpm', 'longitude', 'latitude', 'created_at']);

        return response()->json([
            'code' => 200,
            'data' => $sensor_data
        ]);
    }

    public function getLastMonitoringCode(Request $request){
        $last_monitoring_code = MedicalRecord::find($request->id)->last_monitoring_code;

        $current_code = $last_monitoring_code + 1;

        $codes = [];

        for($i = 0; $i < 3; $i++){
            $codes[$i] = $current_code - 1;
            $current_code--;
        }

        return response()->json([
            'code' => 200,
            'last_monitoring_code' => $codes
        ]);
    }

    public function getDetailSensorDataAndroid(Request $request)
    {
        $last_monitoring_code = MedicalRecord::find($request->id)->last_monitoring_code;
        $pengukuran_1 = PulseOximetry::where('id_pengukuran', $last_monitoring_code - 2)->get(['spo2', 'bpm', 'longitude', 'latitude', 'created_at']);
        $pengukuran_2 = PulseOximetry::where('id_pengukuran', $last_monitoring_code - 1)->get(['spo2', 'bpm', 'longitude', 'latitude', 'created_at']);
        $pengukuran_3 = PulseOximetry::where('id_pengukuran', $last_monitoring_code)->get(['spo2', 'bpm', 'longitude', 'latitude', 'created_at']);

        $detail_sensor = [
            'pengukuran_1' => $pengukuran_1,
            'pengukuran_2' => $pengukuran_2,
            'pengukuran_3' => $pengukuran_3,
        ];

        return response()->json([
            'code' => 200,
            'data_pengukuran' => $detail_sensor
        ]);
    }
}
