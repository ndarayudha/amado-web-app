<?php

namespace App\Models;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\RumahSakit;
use App\Models\MedicalRecord\MedicalRecord;

class RiwayatPenanganan extends Model
{
    use HasFactory;

    protected $fillable = [
        'ket_spo2',
        'ket_bpm',
        'diagnosa',
        'tindak_lanjut',
        'tanggal_masuk',
        'tanggal_keluar',
        'penanganan',
        'saran'
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function rumahSakits()
    {
        return $this->hasMany(RumahSakit::class);
    }

    public function medicalRecords()
    {
        return $this->belongsToMany(MedicalRecord::class);
    }
}
