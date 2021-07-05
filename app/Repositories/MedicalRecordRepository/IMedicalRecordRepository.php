<?php

namespace App\Repositories\MedicalRecordRepository;

interface IMedicalRecordRepository
{
    function getAll($patient_id): array;
    function getMonitoringResult($patient_id): array;
    function save($patient_id, $avgSpo2, $status, $recomendation);
    function update($patient_id);
}
