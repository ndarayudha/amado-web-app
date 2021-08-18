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
                    'id' => $doctorUpdated[0]->id,
                    'name' => $doctorUpdated[0]->name,
                    'email' => $doctorUpdated[0]->email,
                    'jenis_kelamin' => $doctorUpdated[0]->jenis_kelamin,
                    'tanggal_lahir' => $doctorUpdated[0]->tanggal_lahir,
                    'photo' => $doctorUpdated[0]->photo,
                    'address' => $doctorUpdated[0]->address,
                    'phone' => $doctorUpdated[0]->phone,
                    'specialist' => $doctorUpdated[0]->specialists[0]->name,
                    'hospital' => $doctorUpdated[0]->hospitals[0]->name,
                    'created_at' => $doctorUpdated[0]->created_at,
                    'updated_at' => $doctorUpdated[0]->updated_at,
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
        // dd(count($doctorData[0]->specialists->all()) === 0);
        if ($doctorData !== null) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'data dokter ada',
                'user' => [
                    'id' => $doctorData[0]->id ? $doctorData[0]->id : "",
                    'name' => $doctorData[0]->name ? $doctorData[0]->name : "",
                    'email' => $doctorData[0]->email ? $doctorData[0]->email : "",
                    'jenis_kelamin' => $doctorData[0]->jenis_kelamin ? $doctorData[0]->jenis_kelamin : "",
                    'tanggal_lahir' => $doctorData[0]->tanggal_lahir ? $doctorData[0]->tanggal_lahir : "",
                    'photo' => $doctorData[0]->photo ? $doctorData[0]->photo : "",
                    'address' => $doctorData[0]->address ? $doctorData[0]->address : "",
                    'phone' => $doctorData[0]->phone ? $doctorData[0]->phone : "",
                    'specialist' => count($doctorData[0]->specialists->all()) !== 0 ? $doctorData[0]->specialists[0]->name : "",
                    'hospital' => count($doctorData[0]->specialists->all()) !== 0 ? $doctorData[0]->hospitals[0]->name : "",
                    'created_at' => $doctorData[0]->created_at ? $doctorData[0]->created_at : "",
                    'updated_at' => $doctorData[0]->updated_at ? $doctorData[0]->updated_at : "",
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
