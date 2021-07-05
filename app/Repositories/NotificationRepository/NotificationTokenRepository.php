<?php

namespace App\Repositories\NotificationRepository;

use App\Models\Patient\Patient;

interface NotificationTokenRepository
{
    function update(int $patent_id, string $token = ""): Patient;
    function delete(int $pateint_id, string $token = ""): string;
    function get(int $pateint_id): string;
}
