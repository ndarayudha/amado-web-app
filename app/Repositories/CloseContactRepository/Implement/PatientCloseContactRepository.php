<?php

namespace App\Repositories\CloseContactRepository\Implement;

use App\Models\CloseContact\CloseContact;
use App\Models\Patient\Patient;
use App\Repositories\CloseContactRepository\CloseContactRepository;


class PatientCloseContactRepository implements CloseContactRepository
{

    protected Patient $patientModel;
    protected CloseContact $closeContactModel;

    public function __construct(Patient $model, CloseContact $closeContactModel)
    {
        $this->patientModel = $model;
        $this->closeContactModel = $closeContactModel;
    }

    public function store(int $patientId, array $closeContactData): CloseContact
    {
        $convertArrayToObject = (object) $closeContactData;

        $result = $this->patientModel::find($patientId)->closeContacts()->create(
            [
                'address' => "{$convertArrayToObject->address}",
                'name' => "{$convertArrayToObject->name}",
                'relationship' => "{$convertArrayToObject->relationship}",
                'duration' => "{$convertArrayToObject->duration}",
                'time' => "{$convertArrayToObject->time}",
                'date' => "{$convertArrayToObject->date}",
                'latitude' => "{$convertArrayToObject->latitude}",
                'longitude' => "{$convertArrayToObject->longitude}"
            ]
        );

        return $result;
    }
}
