<?php

namespace App\Services\CRUDService\Implement;

use App\Repositories\CRUDRepository\Implement\PatientRepository;
use App\Services\CRUDService\CRUDService;
use Yajra\DataTables\DataTables;

class PatientService implements CRUDService
{
	protected $patientRepository;

	public function __construct(PatientRepository $patientRepository)
	{
		$this->patientRepository = $patientRepository;
	}

	public function create(object $request)
	{
		$photo = $this->upload($request->photo);

		$data = collect($request->except('photo'));
		$data = $data->merge([
			'photo' => $photo
		]);

		$this->repo->create($data->all());
	}

	public function update(int $id, object $request)
	{
		$data = collect($request->except('photo'));

		if ($request->hasFile('photo')) {
			$photo = $this->upload($request->photo);

			$data = $data->merge([
				'photo' => $photo
			]);
		}

		$this->repo->update($id, $data->all());
	}

	public function upload(object $file): String
	{
		$fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$fileName = $fileName . '_' . time() . '.' . $file->extension();

		$file->storeAs('public/img', $fileName);

		return $fileName;
	}

	public function getDatatables(): Object
	{
		$datatables = DataTables::of($this->patientRepository->get())
			->addIndexColumn()
			->addColumn('detail', function ($patient) {
				return '
							<a href="' . route('patient.show', $patient->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
							<button class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button>
						';
			})
			->rawColumns(['detail'])
			->make();

		return $datatables;
	}

	public function getLokasi()
	{
		$result = [];

		$lokasi = $this->patientRepository->get();
		foreach ($lokasi as $value) {
			array_push($result, [
				'nama' => $value->name,
				'alamat' => $value->alamat,
				'longitude' => $value->longitude,
				'latitude' => $value->latitude
			]);
		}
		return $result;
	}
}
