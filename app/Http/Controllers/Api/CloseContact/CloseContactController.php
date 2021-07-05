<?php

namespace App\Http\Controllers\Api\CloseContact;

use App\Http\Controllers\Controller;
use App\Http\Requests\CloseContactRequest;
use App\Services\CloseContactService\Implement\PatientCloseContactService;
use Exception;


class CloseContactController extends Controller
{

    protected PatientCloseContactService $closeContactService;

    public function __construct(PatientCloseContactService $service)
    {
        $this->closeContactService = $service;
    }


    public function storeCloseContact(CloseContactRequest $request)
    {
        $result = $this->closeContactService->storeCloseContact($request);
        try {
            if ($result) {
                return response()->json([
                    "code" => 200,
                    "status" => "berhasil",
                    "message" => "kontak erat berhasil disimpan"
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "code" => 400,
                "status" => "gagal",
                "message" => "kontak erat gagal disimpan"
            ]);
        }
    }
}
