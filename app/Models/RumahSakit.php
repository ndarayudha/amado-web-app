<?php

namespace App\Models;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruang;

class RumahSakit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ruang_id'];

    // rumah sakit has one ruang
    public function ruang()
    {
        return $this->hasOne(Ruang::class);
    }

    public function oksigen()
    {
        return $this->hasOne(Oksigen::class);
    }

    // belongs to doctor
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
