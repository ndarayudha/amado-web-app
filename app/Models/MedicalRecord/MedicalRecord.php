<?php

namespace App\Models\MedicalRecord;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'averrage_spo2',
        'recomendation'
    ];

    /**
     * * this belongs to patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
