<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_benefit')->insert([
            [
                'nama' => 'Tunjangan Jabatan',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ]
        ]);
    }
}
