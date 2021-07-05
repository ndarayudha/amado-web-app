<?php

namespace App\Exports;

use App\Models\Hardware\PulseOximetry;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class OksigenExport implements FromQuery
{
    use Exportable;

    public function __construct(int $patient_id)
    {
        $this->patient_id = $patient_id;
    }

    public function query()
    {
        return PulseOximetry::query()->where(
            'user_device_id',
            $this->patient_id
        );
    }
}
