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

    // ! Deprecated
    public function saveUpdateUser($userAuth, $userUpdateData): Object
    {
        $idDoctor = $userAuth->id;
        $newData = $userUpdateData->all();

        $doctor = $this->doctorModel::find($idDoctor);
        $doctor->update([
            'name' => $newData['name'],
            'jenis_kelamin' => $newData['jenis_kelamin'],
            'tanggal_lahir' => $newData['tanggal_lahir'],
            'phone' => $newData['phone'],
            'address' => $newData['address'],
        ]);
        $doctor->hospitals()->attach($newData['hospital']);
        $doctor->specialists()->attach($newData['specialist']);

        $doctorUpdated = $this->doctorModel::find($idDoctor);

        return $doctorUpdated;
    }

    public function updateDoctor($userAuth, $userUpdateData)
    {
        $idDoctor = $userAuth->id;
        $newData = $userUpdateData->all();

        $doctor = $this->doctorModel::find($idDoctor);
        $doctor->update([
            'name' => $newData['name'],
            'jenis_kelamin' => $newData['jenis_kelamin'],
            'tanggal_lahir' => $newData['tanggal_lahir'],
            'phone' => $newData['phone'],
            'address' => $newData['address'],
        ]);
        $doctor->hospitals()->attach($newData['hospital']);
        $doctor->specialists()->attach($newData['specialist']);

        $doctorUpdated = $this->doctorModel::find($idDoctor)->with(['specialists', 'hospitals'])->get();

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

    // ! Deprecated
    public function getUser($user_id): Doctor
    {
        $doctor = $this->doctorModel::find($user_id);

        return $this->doctorModel;
    }

    public function getDoctor(int $doctor_id)
    {
        $data = $this->doctorModel::find($doctor_id);

        return $data ? $data->with(['specialists', 'hospitals'])->get() : null;
    }
}
