<?php

namespace App\Repositories\CRUDRepository\Implement;

use App\Models\Patient\Patient;
use App\Repositories\CRUDRepository\CRUDRepository;

class PatientRepository implements CRUDRepository
{

	protected $patientModel;

	public function __construct(Patient $model)
	{
		$this->patientModel = $model;
	}

	public function search(string $code = null): Object
	{
		return $this->patientModel->whereStatus(0)->where('code', 'like', '%' . $code . '%')->get(['id', 'code as text', 'title']);
	}

	public function get(): Object
	{
		return $this->patientModel->get();
	}

	public function getById($id): Object
	{
		return $this->patientModel->findOrFail($id);
	}
}
