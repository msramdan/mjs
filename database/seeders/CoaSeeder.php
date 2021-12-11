<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coas')->insert([
            [
                'kode' => '1-000',
                'nama' => 'AKTIVA',
                'parent' => null,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'kode' => '1-1000',
                'nama' => 'AKTIVA LANCAR',
                'parent' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'kode' => '1-1100',
                'nama' => 'KAS BANK',
                'parent' => 2,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'kode' => '1-1100',
                'nama' => 'Kas',
                'parent' => 3,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ]
        ]);
    }
}
