<?php

namespace App\Models\Device;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device\Device;
use App\Models\Patient\Patient;
use App\Models\Hardware\PulseOximetry;

class UserDevice extends Model
{
    use HasFactory;

    protected $table = 'user_devices';

    protected $fillable = [
        'serial_number',
        'api_token'
    ];


    public function device()
    {
        return $this->hasOne(Device::class);
    }

    /**
     * * Device belongs to one patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * * Device has pulse oximetry
     */
    public function pulseOximetries()
    {
        return $this->hasMany(PulseOximetry::class);
    }
}
