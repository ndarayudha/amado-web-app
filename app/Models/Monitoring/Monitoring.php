<?php

namespace App\Models\Monitoring;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_monitoring'
    ];


    /**
     * * Monitoring belongs to patent
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
