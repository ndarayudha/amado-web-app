<?php

namespace App\Models\Device;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device\UserDevice;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'name',
        'serial_number'
    ];

    public function userDevice()
    {
        return $this->belongsTo(UserDevice::class);
    }
}
