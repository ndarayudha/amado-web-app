<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialist::create([
            'name' => 'Spelialis Jantung'
        ]);

        Specialist::create([
            'name' => 'Spelialis Bedah'
        ]);

        Specialist::create([
            'name' => 'Spelialis Organ Dalam'
        ]);

        Specialist::create([
            'name' => 'Spelialis Kulit'
        ]);

        Specialist::create([
            'name' => 'Spelialis Mata'
        ]);
    }
}
