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
                // 1
                'kode' => '1-0000',
                'nama' => 'Aktiva',
                'tipe' => 'Asset',
                'kategori' => 'Parent',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 2
                'kode' => '1-1000',
                'nama' => 'Aktiva Lancar',
                'tipe' => 'Asset',
                'kategori' => 'Header',
                'parent'  => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 3
                'kode' => '1-1100',
                'nama' => 'Kas & Bank',
                'tipe' => 'Bank',
                'kategori' => 'Header',
                'parent'  => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 4
                'kode' => '1-1110',
                'nama' => 'Kas',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 5
                'kode' => '1-1110',
                'nama' => 'Bank BCA',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 6
                'kode' => '1-1110',
                'nama' => 'Bank BSM',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 7
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
                // 8
                'kode' => '2-0000',
                'nama' => 'Kewajiban',
                'tipe' => 'Bank',
                'kategori' => 'Parent',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 9
                'kode' => '2-1000',
                'nama' => 'Kewajiban Lancar',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 10
                'kode' => '2-2000',
                'nama' => 'Kewajiban Tidak Lancar',
                'tipe' => 'Bank',
                'kategori' => 'Detail',
                'parent'  => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // End of Kewajiban

            [
                // 11
                'kode' => '6-0000',
                'nama' => 'Beban',
                'tipe' => 'Expense',
                'kategori' => 'Parent',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 12
                'kode' => '6-1000',
                'nama' => 'Beban Pokok Pendapatan Usaha',
                'tipe' => 'Expense',
                'kategori' => 'Header',
                'parent'  => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 13
                'kode' => '6-1100',
                'nama' => 'Beban Tenaga Kerja Langsung',
                'tipe' => 'Expense',
                'kategori' => 'Detail',
                'parent'  => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 14
                'kode' => '6-1100',
                'nama' => 'Beban Agenci',
                'tipe' => 'Expense',
                'kategori' => 'Detail',
                'parent'  => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // end of beban
            // Biaya Lain lain
            [
                //15
                'kode' => '9-0000',
                'nama' => 'Biaya Lain lain',
                'tipe' => 'Other Expenses',
                'kategori' => 'Parent',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 16
                'kode' => '9-1000',
                'nama' => 'Biaya Lain-lain',
                'tipe' => 'Other Expenses',
                'kategori' => 'Detail',
                'parent'  => 15,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 17
                'kode' => '9-1100',
                'nama' => 'Biaya Administrasi Bank/Bea Transfer',
                'tipe' => 'Other Expenses',
                'kategori' => 'Detail',
                'parent'  => 15,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 18
                'kode' => '10-0000',
                'nama' => 'Piutang',
                'tipe' => 'Euqity',
                'kategori' => 'Parent',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 19
                'kode' => '10-1000',
                'nama' => 'Piutang PT. XXX XXX',
                'tipe' => 'Euqity',
                'kategori' => 'Detail',
                'parent'  => 18,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 20
                'kode' => '10-1100',
                'nama' => 'Piutang PT. YYY YYY',
                'tipe' => 'Euqity',
                'kategori' => 'Detail',
                'parent'  => 18,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 21
                'kode' => '11-0000',
                'nama' => 'Pendapatan',
                'tipe' => 'Income',
                'kategori' => 'Parent',
                'parent'  => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 22
                'kode' => '11-1000',
                'nama' => 'Pendapatan Tetap',
                'tipe' => 'Income',
                'kategori' => 'Detail',
                'parent'  => 21,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                // 23
                'kode' => '11-1000',
                'nama' => 'Pendapatan Tidak Tetap',
                'tipe' => 'Income',
                'kategori' => 'Detail',
                'parent'  => 21,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
