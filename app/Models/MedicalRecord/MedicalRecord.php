<?php

namespace App\Models\MedicalRecord;

use App\Models\Patient\Patient;
use App\Models\RiwayatPenanganan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'averrage_spo2',
        'averrage_bpm',
        'recomendation',
        'konfirmasi',
        'last_monitoring_code',
        'url',
    ];

    /**
     * * this belongs to patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->format('d, M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
            ->format('d, M Y H:i');
    }

    public function riwayatPenangnanans()
    {
        return $this->belongsToMany(RiwayatPenanganan::class);
    }
}
