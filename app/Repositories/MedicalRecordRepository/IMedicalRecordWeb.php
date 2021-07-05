<?php

namespace App\Repositories\MedicalRecordRepository;


interface IMedicalRecordWeb
{
    function get(): Object;
    function getById($patient_id): Object;
    function search(string $code = null): Object;
}
