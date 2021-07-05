<?php

namespace App\Repositories\UserRepository;

use App\Models\Patient\Patient;

interface UserGraphRepository
{
    function countByMonth(int $month);
    function getPatientGender();
    function getPatientAge($ranges);
}
