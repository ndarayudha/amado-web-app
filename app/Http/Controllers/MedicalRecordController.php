<?php

namespace App\Http\Controllers;

use App\Exports\OksigenExport;
use App\Repositories\MedicalRecordRepository\Implement\PatientMedicalRecordWebRepository;
use App\Services\MedicalRecordService\Implement\PatientMedicalRecordServiceWeb;
use App\Services\MedicalRecordService\Implement\PatientMedicalRecordService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Maatwebsite\Excel\Facades\Excel;

class MedicalRecordController extends Controller
{

    protected $service;
    protected $repo;
    protected PatientMedicalRecordService $medicalRecord;

    public function __construct(
        PatientMedicalRecordServiceWeb $service,
        PatientMedicalRecordWebRepository $repo,
        PatientMedicalRecordService $medicalRecord
    ) {
        $this->service = $service;
        $this->repo = $repo;
        $this->medicalRecord = $medicalRecord;
    }


    public function getMedicalRecord(Request $request)
    {
        $result = $this->medicalRecord->getMedicalRecord($request->patient_id);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'patient' => $result['user'],
            'monitoring_location' => $result['monitoring_location'],
            'close_contacts' => $result['close_contact'],
            'device_type' => $result['device_type'],
            'monitoring_result' => $result['monitoring_result']
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('record.medical-record');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = $this->medicalRecord->getMedicalRecord($id);



        return view('record.show', compact('patient'));
    }


    public function printPdf($id)
    {
        $patient = $this->medicalRecord->getMedicalRecord($id);
        $pdf = PDF::loadview('pasien-pdf', ['patient' => $patient]);
        return $pdf->download('rekam-medis-pasien');
    }

    public function exportOxygenExel($id = 1)
    {
        return Excel::download(new OksigenExport($id), 'oksigen.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function datatables(): Object
    {
        return $this->service->getDatatables();
    }

    public function search(Request $request): Object
    {
        return $this->repo->search($request->code);
    }
}
