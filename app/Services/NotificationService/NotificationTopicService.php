<?php

namespace App\Services\NotificationService;

interface NotificationTopicService
{
    function updateTopic(int $patient_id, int $topic): bool;
    function deleteTopic(int $patient_id, int $topic): bool;
    function getTopic(int $patient_id);
}
