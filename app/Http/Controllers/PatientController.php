<?php

namespace App\Http\Controllers;

use App\Models\Patient\Patient;
use App\Repositories\CRUDRepository\Implement\PatientRepository;
use App\Services\CRUDService\Implement\PatientService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class PatientController extends Controller
{

    protected $service;
    protected $repo;

    public function __construct(PatientService $service, PatientRepository $repo)
    {
        $this->service = $service;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('patient.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('patient.create');
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
        $patient = $this->repo->getById($id);

        return view('patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = $this->repo->getById($id);

        return view('patient.edit', compact('patient'));
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
        $this->service->update($id, $request);

        return redirect('/patient')->with('success', 'Sukses Mengedit Data Pasien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();

        return response()->json('Sukses Menghapus Data Pasien');
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
