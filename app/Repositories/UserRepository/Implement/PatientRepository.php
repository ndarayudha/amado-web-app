<?php

namespace App\Repositories\UserRepository\Implement;

use App\Repositories\UserRepository\UserRepository;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\Storage;

class PatientRepository implements UserRepository
{

    protected $patientModel;

    public function __construct(Patient $model)
    {
        $this->patientModel = $model;
    }

    // save update patien to database
    public function saveUpdateUser($userAuth, $userUpdateData): Object
    {
        $idPatient = $userAuth->id;
        $newData = $userUpdateData->all();

        $this->patientModel::find($idPatient)
            ->update([
                'name' => $newData['name'],
                'nik' => $newData['nik'],
                'jenis_kelamin' => $newData['jenis_kelamin'],
                'tanggal_lahir' => $newData['tanggal_lahir'],
                'phone' => $newData['phone'],
                'alamat' => $newData['alamat']
            ]);

        $patientUpdated = $this->patientModel::find($idPatient);

        return $patientUpdated;
    }


    // save patien photo profile to database
    public function savePhotoProfile($userAuth, $photo)
    {
        $idPatient = $userAuth->id;

        $imageName = time() . '.' . 'png';

        $path = "profiles/$imageName";

        Storage::disk('public-image')->put($imageName, $photo);

        $this->patientModel::find($idPatient)
            ->update([
                'photo' => $path
            ]);

        $patientPhotoUpdated = $this->patientModel::find($idPatient);

        return $patientPhotoUpdated;
    }


    /**
     * ! Sementara untuk update geolokasi, nanti akan direfaktof menjadi service geolokasi
     */
    public function updateGeolocation($patient_id, $coordinate)
    {

        $coordinateUpdated = $this->patientModel::find($patient_id);
        $coordinateUpdated->update([
            'latitude' => $coordinate['latitude'],
            'longitude' => $coordinate['longitude']
        ]);

        return $coordinateUpdated->fresh();
    }


    public function getPhotoProfile($user_id)
    {
        $filePath = $this->patientModel::find($user_id)->photo;

        if ($filePath != null) {
            return $filePath;
        }

        return null;
    }

    public function getUser($user_id): Patient
    {
        $patient = Patient::find($user_id);
        return $patient;
    }


    /**
     * * This is made for PatientProfileControlller
     * * Please split to another Repository yet
     */
    public function getPatients()
    {
        $patient = $this->patientModel::get(['id', 'name', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'longitude', 'latitude', 'konfirmasi']);
        return $patient ? $patient : null;
    }
}
