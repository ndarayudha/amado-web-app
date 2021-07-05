<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService\Implement\PatientNotificationService;

class NotificationPatientController extends Controller
{
    protected PatientNotificationService $patientService;


    public function __construct(PatientNotificationService $service)
    {
        $this->patientService = $service;
    }


    /**
     * * Handle Firebase Notification API Token
     */
    public function updateApiToken(Request $request)
    {
        $result = $this->patientService->updateToken($request);
        if ($result) {
            return response()->json([
                'code' => 201,
                'status' => 'berhasil',
                'message' => 'token berhasil update'
            ], 201);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'token gagal update'
        ], 400);
    }


    public function deleteApiToken(Request $request)
    {
        $result = $this->patientService->deleteToken($request);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'token berhasil dihapus'
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'token gagal dihapus'
        ]);
    }


    public function getApiToken()
    {
    }


    /**
     * * Handle Firebase Topic Notification
     */
    public function saveTopic()
    {
    }


    /**
     * ! JUST FOR TEST
     */
    public function updateTopic(Request $request)
    {
        $result = $this->patientService->updateTopic($request->id, 1);

        if ($result) {
            return response()->json([
                'code' => 201,
                'status' => 'berhasil',
                'message' => 'topic berhasil diupdate'
            ], 201);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'topic gagal diupdate'
        ], 400);
    }


    public function deleteTopic(Request $request)
    {
        $result = $this->patientService->deleteTopic($request->id, 1);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'message' => 'topic berhasil dihapus'
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'topic gagal diupdate'
        ]);
    }


    public function getTopics(Request $request)
    {
        $result = $this->patientService->getTopic($request->id, 1);

        if ($result) {
            return response()->json([
                'code' => 200,
                'status' => 'berhasil',
                'topics' => $result
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'topic tidak ada'
        ]);
    }
}
