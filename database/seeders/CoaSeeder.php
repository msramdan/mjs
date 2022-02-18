<?php

namespace Database\Seeders;

use App\Models\Accounting\Coa;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coa::insert([
            // Aktiva
            [
                'kode' => '1-0000',
                'nama' => 'Aktiva',
                'tipe' => 'Asset',
                'kategori' => 'Header',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => '1-1000',
                'nama' => 'Aktiva Lancar',
                'tipe' => 'Asset',
                'kategori' => 'Detail',
                'parent'  => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => '1-2000',
                'nama' => 'Aktiva Tidak Lancar',
                'tipe' => 'Asset',
                'kategori' => 'Detail',
                'parent'  => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // End of Aktiva
            // Kewajiban
            [
                'kode' => '2-0000',
                'nama' => 'Kewajiban',
                'tipe' => 'Bank',
                'kategori' => 'Header',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => '2-1000',
                'nama' => 'Kewajiban Lancar',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => '2-2000',
                'nama' => 'Kewajiban Tidak Lancar',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // End of Kewajiban
        ]);
    }
}
