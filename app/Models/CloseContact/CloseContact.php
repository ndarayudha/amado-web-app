<?php

namespace App\Models\CloseContact;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloseContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'name',
        'relationship',
        'duration',
        'time',
        'date',
        'latitude',
        'longitude'
    ];


    /**
     * * CLose contact belongs to patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
