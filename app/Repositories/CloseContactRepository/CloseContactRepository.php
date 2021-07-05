<?php

namespace App\Repositories\CloseContactRepository;

use App\Models\CloseContact\CloseContact;

interface CloseContactRepository
{
    function store(int $patientId, array $closeContactData): CloseContact;
}
