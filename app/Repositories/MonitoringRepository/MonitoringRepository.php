<?php

namespace App\Repositories\MonitoringRepository;

interface MonitoringRepository
{
    function update(int $patient_id, int $currentUpdateStatus);
    function create(int $patient_id, int $initialValue);
    function get(int $patient_id);
}
