<?php

namespace App\Services\UserService\Implement;

use App\Repositories\UserRepository\Implement\PatientRepositoryWeb;
use App\Services\UserService\UserGraphService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientServiceWeb implements UserGraphService
{

    protected $patientRepository;

    public function __construct(PatientRepositoryWeb $patientRepositoryWeb)
    {
        $this->patientRepository = $patientRepositoryWeb;
    }


    // get patient data per month
    public function getPerMonth(): array
    {
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $pasien = $this->patientRepository->countByMonth($i);

            array_push($data, $pasien);
        }

        return $data;
    }

    // get patient with gender
    public function getGender()
    {
        $total = [];
        $gender = [];
        $patient = $this->patientRepository->getPatientGender()->all();
        // dd($patient);

        // array_push($total, $patient['laki - laki']->count());
        // array_push($gender, 'laki - laki');

        // array_push($total, $patient['perempuan']->count());
        // array_push($gender, 'perempuan');

        foreach ($patient as $key => $value) {
            array_push($total, count($value->all()));
            array_push($gender, $key);
        }

        return [
            'total' => $total,
            'gender' => $gender
        ];
    }

    // get patient with age
    public function getAge()
    {
        $total = [];
        $range = [];
        $ranges = [ // the start of each age-range.
            '12-19' => [12, 19],
            '20-25' => [20, 25],
            '26-50' => [26, 50],
            '50+' => [51, 100],
        ];

        $patient = $this->patientRepository->getPatientAge($ranges);
        // dd($patient);

        foreach ($patient as $key => $value) {
            array_push($total, $value);
            array_push($range, $key);
        }

        return [
            'total' => $total,
            'range' => $range
        ];
    }
}
