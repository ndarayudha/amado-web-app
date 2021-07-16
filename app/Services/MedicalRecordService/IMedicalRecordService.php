<?php

namespace App\Services\MedicalRecordService;

interface IMedicalRecordService
{
    function createMedicalRecord($patient_id, array $resultSensor);
    function getMedicalRecord($patient_id);
    function updateMedicalRecord($patient_id);
}
