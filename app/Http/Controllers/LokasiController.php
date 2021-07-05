<?php

namespace App\Http\Controllers;

use App\Repositories\CRUDRepository\Implement\PatientRepository;
use App\Services\CRUDService\Implement\PatientService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LokasiController extends Controller
{
    protected $repo;
    protected $service;

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
        // $lokasi = $this->repo->get();
        // dd($lokasi);
        $lokasi = $this->service->getLokasi();

        return view('lokasi.index', compact('lokasi'));
    }
}
