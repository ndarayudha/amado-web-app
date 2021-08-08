<?php

namespace App\Http\Controllers\ApiWeb;

use App\Http\Controllers\Controller;
use App\Services\UserService\Implement\DoctorService;
use Illuminate\Http\Request;
use Exception;

class DoctorProfileController extends Controller
{
    private DoctorService $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function update(Request $request)
    {

        try {
            $doctorUpdated = $this->doctorService->updateUser($request);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'data dokter telah di update',
                'user' => [
                    'id' => $doctorUpdated->id,
                    'name' => $doctorUpdated->name,
                    'email' => $doctorUpdated->email,
                    'jenis_kelamin' => $doctorUpdated->jenis_kelamin,
                    'tanggal_lahir' => $doctorUpdated->tanggal_lahir,
                    'address' => $doctorUpdated->address,
                    'phone' => $doctorUpdated->phone,
                    'specialist' => $doctorUpdated->specialist,
                    'created_at' => $doctorUpdated->created_at,
                    'updated_at' => $doctorUpdated->updated_at,
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
            $doctorPhoto = $this->doctorService->updateUserPhoto($request);

            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'foto profil berhasil ditambahkan',
                'user' => [
                    'id' => $doctorPhoto->id,
                    'name' => $doctorPhoto->name,
                    'photo' => $doctorPhoto->photo,
                    'created_at' => $doctorPhoto->created_at,
                    'updated_at' => $doctorPhoto->updated_at
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
        $base64Format = $this->doctorService->getUserPhoto($request);

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
        $doctorData = $this->doctorService->getBiodata($request);

        if ($doctorData != null) {
            return response()->json([
                "code" => 200,
                "status" => "berhasil",
                "user" => [
                    "id" => $doctorData->id,
                    "name" => $doctorData->name,
                    "email" => $doctorData->email,
                    "jenis_kelamin" => $doctorData->jenis_kelamin,
                    "address" => $doctorData->address,
                    "tangggal_lahir" => $doctorData->tanggal_lahir,
                    "phone" => $doctorData->phone,
                    'specialist' => $doctorData->specialist
                ]
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'dokter belum terdaftar'
        ]);
    }
}
