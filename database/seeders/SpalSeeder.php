<?php

namespace Database\Seeders;

use App\Models\Sale\Spal;
use Illuminate\Database\Seeder;

class SpalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spal = Spal::create([
            'customer_id' => 1,
            'kode' => 'SPAL-0001',
            'nama_kapal' => 'Kapal 1',
            'nama_muatan' => 'Muatan 1',
            'jml_muatan' => 9,
            'pelabuhan_muat' => 'Pelabuhan 1',
            'pelabuhan_bongkar' => 'Pelabuhan 2',
            'harga_unit' => 100000,
            'harga_demorage' => 25000000
        ]);

        $spal->file_spal()->create([
            'nama' => 'File 1',
            'file' => 'file-1.docx',
        ]);
    }
}
