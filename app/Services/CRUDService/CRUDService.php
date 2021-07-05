<?php

namespace App\Services\CRUDService;


interface CRUDService
{
    function create(object $request);
    function update(int $id, object $request);
    function upload(object $file);
    function getDataTables();
    function getLokasi();
}
