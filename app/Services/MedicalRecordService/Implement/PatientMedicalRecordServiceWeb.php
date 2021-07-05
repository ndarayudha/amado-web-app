<?php

namespace App\Services\MedicalRecordService\Implement;

use App\Services\MedicalRecordService\IMedicalRecordServiceWeb;
use App\Repositories\MedicalRecordRepository\Implement\PatientMedicalRecordWebRepository;
use Yajra\DataTables\DataTables;

class PatientMedicalRecordServiceWeb implements IMedicalRecordServiceWeb
{
    protected PatientMedicalRecordWebRepository $medicalRecordRepo;

    public function __construct(PatientMedicalRecordWebRepository $repo)
    {
        $this->medicalRecordRepo = $repo;
    }

    public function create(object $request)
    {
        // $photo = $this->upload($request->photo);

        // $data = collect($request->except('photo'));
        // $data = $data->merge([
        //     'photo' => $photo
        // ]);

        // $this->repo->create($data->all());
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

    public function getDatatables(): object
    {
        $datatables = DataTables::of($this->medicalRecordRepo->get())
            ->addIndexColumn()
            ->addColumn('detail', function ($record) {
                return '
							<a href="' . route('record.show', $record->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
						';
            })
            ->rawColumns(['detail'])
            ->make();

        return $datatables;
    }
}
