<?php

namespace Database\Seeders;

use App\Models\Master\StatusKaryawan;
use Illuminate\Database\Seeder;

class StatusKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusKaryawan::factory()->count(7)->create();
    }
}
