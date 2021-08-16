<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ruang::create([
            'name' => 'A',
            'kapasitas_ruang' => '20'
        ]);

        Ruang::create([
            'name' => 'B',
            'kapasitas_ruang' => '25'
        ]);
    }
}
