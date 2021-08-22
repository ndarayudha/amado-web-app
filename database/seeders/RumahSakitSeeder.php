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
            'name' => 'RS A',
            'alamat' => 'Dusun Karanglo, Desa Sukonatar, Kecamatan Srono, Banyuwangi',
            'telp' => '081123456789'
        ]);

        ModelsRumahSakit::create([
            'name' => 'RS B',
            'alamat' => 'Dusun Karanglo, Desa Sukonatar, Kecamatan Srono, Banyuwangi',
            'telp' => '081123456789'
        ]);
    }
}
