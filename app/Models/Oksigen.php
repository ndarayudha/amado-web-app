<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oksigen extends Model
{
    use HasFactory;

    protected $fillable = ['kapasitas_oksigen', 'oksigen_terpakai'];
}
