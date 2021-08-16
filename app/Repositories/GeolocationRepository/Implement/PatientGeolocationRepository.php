<?php

namespace App\Repositories\GeolocationRepository\Implement;

use App\Models\Patient\Patient;
use App\Repositories\GeolocationRepository\Geolocation;
use Illuminate\Support\Facades\Log;

class PatientGeolocationRepository implements Geolocation
{

    private Patient $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function getAll(): array
    {
        $collection = $this->patient->all()->map(function ($value) {
            return $value->only(['id', 'name', 'latitude', 'longitude']);
        });

        Log::info("get all patient location, data: {$collection}");

        return $collection->all();
    }

    public function getAllCloseContact(): array
    {
        return [];
    }
}
