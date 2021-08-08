<?php

namespace App\Repositories\UserRepository\Implement;

use App\Repositories\UserRepository\UserRepository;
use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;

class DoctorRepository implements UserRepository
{

    protected Doctor $doctorModel;

    public function __construct(Doctor $doctorModel)
    {
        $this->doctorModel = $doctorModel;
    }

    public function saveUpdateUser($userAuth, $userUpdateData): Object
    {
        $idDoctor = $userAuth->id;
        $newData = $userUpdateData->all();

        $this->doctorModel::find($idDoctor)
            ->update([
                'name' => $newData['name'],
                'jenis_kelamin' => $newData['jenis_kelamin'],
                'tanggal_lahir' => $newData['tanggal_lahir'],
                'phone' => $newData['phone'],
                'address' => $newData['address'],
                'specialist' => $newData['specialist']
            ]);

        $doctorUpdated = $this->doctorModel::find($idDoctor);

        return $doctorUpdated;
    }


    public function savePhotoProfile($userAuth, $photo)
    {
        $idDoctor = $userAuth->id;

        $imageName = time() . '.' . 'png';

        $path = "profiles/$imageName";

        Storage::disk('public-image')->put($imageName, $photo);

        $this->doctorModel::find($idDoctor)
            ->update([
                'photo' => $path
            ]);

        $doctorPhotoUpdated = $this->doctorModel::find($idDoctor);

        return $doctorPhotoUpdated;
    }


    public function getPhotoProfile($user_id)
    {
        $filePath = $this->doctorModel::find($user_id)->photo;

        if ($filePath != null) {
            return $filePath;
        }

        return null;
    }

    public function getUser($user_id): Doctor
    {
        $doctor = Doctor::find($user_id);
        return $doctor;
    }
}
