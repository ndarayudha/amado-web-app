<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RumahSakit;

class Oksigen extends Model
{
    use HasFactory;

    protected $fillable = ['kapasitas_oksigen', 'oksigen_terpakai'];


    public function rumahSakits()
    {
        return $this->belongsToMany(RumahSakit::class);
    }
}
