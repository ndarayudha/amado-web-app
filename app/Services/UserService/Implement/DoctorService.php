<?php

namespace App\Services\UserService\Implement;

use App\Models\Doctor;
use App\Repositories\UserRepository\Implement\DoctorRepository;
use App\Services\UserService\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DoctorService implements UserService
{

    protected DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function updateUser($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'specialist' => 'required',
            'hospital' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $doctorUpdateData = collect($request);
        $doctorHasBeenAuthenticated = Auth::guard('doctor-api')->user();

        $doctorUpdated = $this->doctorRepository->updateDoctor($doctorHasBeenAuthenticated, $doctorUpdateData);

        return $doctorUpdated;
    }


    public function updateUserPhoto($request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        // get base 64 file
        $doctorPhotoFile = $request->photo;

        // get doctor authenticated
        $doctorHasBeenAuthenticated = Auth::guard('doctor-api')->user();

        // convert to image
        $image = convertBase64ToImageOnly($doctorPhotoFile);

        // save profile
        $doctorPhotoUpdated = $this->doctorRepository->savePhotoProfile($doctorHasBeenAuthenticated, $image);

        return $doctorPhotoUpdated;
    }



    public function getUserPhoto($request)
    {
        $doctorHasBeenAuthenticated = Auth::guard('doctor-api')->user();

        $imagePath = $this->doctorRepository->getPhotoProfile($doctorHasBeenAuthenticated->id);

        if ($imagePath != null) {
            $base64Data = Cache::remember('doctor-photo', 3, function () use ($imagePath) {
                $base64 =  convertImageToBase64($imagePath);
                return $base64;
            });
            return $base64Data;
        }

        return null;
    }

    public function getBiodata($request)
    {
        $doctorId = $request->id;
        $doctorProfile = Cache::remember('doctor-bio', 60 * 60, function () use ($doctorId) {
            $doctorBiodata = $this->doctorRepository->getDoctor($doctorId);
            return $doctorBiodata;
        });

        return $doctorProfile;
    }
}
