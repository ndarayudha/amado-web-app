<?php

namespace App\Repositories\UserRepository;

use App\Models\Patient\Patient;

interface UserRepository
{
    public function saveUpdateUser($userAuth, $userUpdateData): Object;
    public function savePhotoProfile($userAuth, $photo);
    public function getPhotoProfile($user_id);
    function getPatient($patient_id): Patient;
}
