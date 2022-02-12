<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_request')->insert([
            'kode' => 'F1',
            'nama' => 'WALFARE',
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ]);

        // [
        //     'kode' => 'F2',
        //     'nama' => 'TUGBOAT FUEL OIL',
        //     'created_at' => now()->toDateTimeString(),
        //     'updated_at' => now()->toDateTimeString()
        // ],
        // [
        //     'kode' => 'F3',
        //     'nama' => 'SPARE PART MAINTENANCE',
        //     'created_at' => now()->toDateTimeString(),
        //     'updated_at' => now()->toDateTimeString()
        // ],
        // [
        //     'kode' => 'F4',
        //     'nama' => 'STEEL MATERIAL MAINTENANCE',
        //     'created_at' => now()->toDateTimeString(),
        //     'updated_at' => now()->toDateTimeString()
        // ],
        // [
        //     'kode' => 'F5',
        //     'nama' => 'MACHINE, NAVIGATION EQUIPMENT MAINTENANCE',
        //     'created_at' => now()->toDateTimeString(),
        //     'updated_at' => now()->toDateTimeString()
        // ],
        // [
        //     'kode' => 'F6',
        //     'nama' => 'OPERATIONAL SITE',
        //     'created_at' => now()->toDateTimeString(),
        //     'updated_at' => now()->toDateTimeString()
        // ],
        // [
        //     'kode' => 'F7',
        //     'nama' => 'SERVICES/MAINTENANCE ALL SHIPS',
        //     'created_at' => now()->toDateTimeString(),
        //     'updated_at' => now()->toDateTimeString()
        // ],
    }
}
