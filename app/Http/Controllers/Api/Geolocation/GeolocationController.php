<?php

namespace App\Http\Controllers\Api\Geolocation;

use App\Http\Controllers\Controller;
use App\Repositories\GeolocationRepository\Implement\PatientGeolocationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeolocationController extends Controller
{

    private PatientGeolocationRepository $patientGeoRepository;

    public function __construct(PatientGeolocationRepository $patientGeoRepository)
    {
        $this->patientGeoRepository = $patientGeoRepository;
    }


    public function getAllPatientLocation()
    {
        $result = $this->patientGeoRepository->getAll();

        if ($result !== null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'data' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'data' => 'tidak ada pasien lain yang terdaftar'
        ]);
    }
}
