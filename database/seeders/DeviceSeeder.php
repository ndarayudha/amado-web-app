<?php

namespace Database\Seeders;

use App\Models\Device\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::create([
            'name' => 'Pulse Oximetry'
        ]);
    }
}
