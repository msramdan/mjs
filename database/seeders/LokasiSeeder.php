<?php

namespace Database\Seeders;

use App\Models\Master\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lokasi::factory()->count(5)->create();
    }
}
