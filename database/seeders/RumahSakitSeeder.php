<?php

namespace Database\Seeders;

use App\Models\RumahSakit as ModelsRumahSakit;
use Illuminate\Database\Seeder;

class RumahSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsRumahSakit::create([
            'name' => 'RS Al-Huda',
            'ruang_id' => '1',
        ]);

        ModelsRumahSakit::create([
            'name' => 'RS Fatimah',
            'ruang_id' => '2',
        ]);
    }
}
