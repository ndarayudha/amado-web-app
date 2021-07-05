<?php

namespace App\Services\MedicalRecordService;

interface IMedicalRecordService
{
    function createMedicalRecord($patient_id, $resultSensor);
    function getMedicalRecord($patient_id);
    function updateMedicalRecord($patient_id);
}
