<?php

namespace Database\Seeders;

use App\Models\Master\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Divisi::factory()->count(5)->create();
    }
}
