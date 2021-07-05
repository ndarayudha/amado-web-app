<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService\Implement\PatientService;
use Exception;

class PatientProfileController extends Controller
{
    protected $patientService;

    public function __construct(
        PatientService $patientService
    ) {
        $this->patientService = $patientService;
    }


    public function updatePatientLocation(Request $request)
    {
        try {
            $currentLocation = $this->patientService->updateGeolocation($request);
            if ($currentLocation) {
                return response()->json([
                    'code' => 200,
                    'message' => 'success',
                    'latitude' => $currentLocation->latitude,
                    'longitude' => $currentLocation->longitude
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'failed',
                'message' => 'update location failed'
            ]);
        }
    }


    public function update(Request $request)
    {

        try {
            $patientUpdated = $this->patientService->updateUser($request);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'data pasien telah di update',
                'user' => [
                    'id' => $patientUpdated->id,
                    'name' => $patientUpdated->name,
                    'email' => $patientUpdated->email,
                    'nik' => $patientUpdated->nik,
                    'jenis_kelamin' => $patientUpdated->jenis_kelamin,
                    'alamat' => $patientUpdated->alamat,
                    'tanggal_lahir' => $patientUpdated->tanggal_lahir,
                    'phone' => $patientUpdated->phone,
                    'created_at' => $patientUpdated->created_at,
                    'updated_at' => $patientUpdated->updated_at,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'gagal',
                'message' => $e
            ]);
        }
    }



    public function saveUserProfile(Request $request)
    {

        try {
            $patientPhoto = $this->patientService->updateUserPhoto($request);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'foto profil berhasil ditambahkan',
                'user' => [
                    'id' => $patientPhoto->id,
                    'name' => $patientPhoto->name,
                    'photo' => $patientPhoto->photo,
                    'created_at' => $patientPhoto->created_at,
                    'updated_at' => $patientPhoto->updated_at
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'gagal',
                'message' => 'gambar gagal diupload'
            ]);
        }
    }



    public function getUserPhoto(Request $request)
    {
        $base64Format = $this->patientService->getUserPhoto($request);

        if ($base64Format != null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => $base64Format
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'gambar gagal diupload'
        ]);
    }


    public function getBiodata(Request $request)
    {
        $patientData = $this->patientService->getBiodata($request);

        if ($patientData != null) {
            return response()->json([
                "code" => 200,
                "status" => "berhasil",
                "message" => "data pasien berhasil ditamabahkan",
                "user" => [
                    "id" => $patientData->id,
                    "name" => $patientData->name,
                    "email" => $patientData->email,
                    "nik" => $patientData->nik,
                    "jenis_kelamin" => $patientData->jenis_kelamin,
                    "alamat" => $patientData->alamat,
                    "tangggal_lahir" => $patientData->tanggal_lahir,
                    "phone" => $patientData->phone,
                ]
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'pasien belum terdaftar'
        ]);
    }
}
