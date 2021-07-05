<?php

namespace App\Repositories\NotificationRepository;

interface NotificationTopicRepository
{
    function delete(int $patient_id, int $topic): array;
    function update(int $patient_id, int $topic): array;
    function get(int $patient_id): array;
}
