<?php

namespace App\Repositories\CRUDRepository;

use App\Models\Patient\Patient;

interface CRUDRepository
{
    public function search(string $code = null);
    public function get();
    public function getById($id);
}
