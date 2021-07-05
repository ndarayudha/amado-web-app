<?php

namespace App\Repositories\UserRepository\Implement;

use App\Repositories\UserRepository\UserGraphRepository;
use App\Models\Patient\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PatientRepositoryWeb implements UserGraphRepository
{

    protected $patientModel;

    public function __construct(Patient $model)
    {
        $this->patientModel = $model;
    }

    // query get patient with month
    public function countByMonth(int $month): Int
    {
        return $this->patientModel->whereMonth('created_at', $month)->count();
    }

    // query get gender patient
    public function getPatientGender()
    {
        return $this->patientModel->get()->groupBy('jenis_kelamin', 'asscending');
    }

    public function getPatientAge($ranges)
    {
        return $this->patientModel->get()->map(function ($user) use ($ranges) {
            $age = Carbon::parse($user->tanggal_lahir)->diffInYears(Carbon::now());
            foreach ($ranges as $key => $breakpoint) {
                ($age >= $breakpoint[0] && $age <= $breakpoint[1] ? $user->range = $key : '');
            }

            return $user;
        })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->sortKeys();
    }
}
