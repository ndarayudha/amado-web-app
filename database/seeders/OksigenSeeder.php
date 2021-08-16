<?php

namespace Database\Seeders;

use App\Models\Oksigen;
use Illuminate\Database\Seeder;

class OksigenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Oksigen::create([
            'kapasitas_oksigen' => '200'
        ]);

        Oksigen::create([
            'kapasitas_oksigen' => '100'
        ]);
    }
}
