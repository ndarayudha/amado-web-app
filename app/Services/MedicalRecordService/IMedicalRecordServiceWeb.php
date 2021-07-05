<?php

namespace App\Services\MedicalRecordService;

interface IMedicalRecordServiceWeb
{
    function create(object $request);
    function update(int $id, object $request);
    function upload(object $file);
    function getDataTables();
}
