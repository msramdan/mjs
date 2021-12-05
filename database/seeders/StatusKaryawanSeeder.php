<?php

namespace Database\Seeders;

use App\Models\Master\StatusKaryawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // kalo mau make factory/data random/dummy
        // StatusKaryawan::factory()->count(7)->create();

        DB::table('status_karyawan')->insert(
            [
                [
                    'nama' => 'Karyawan Tetap',
                    'status' => 'Aktif',
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ],
                [
                    'nama' => 'Karyawan Kontak',
                    'status' => 'Aktif',
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ],
                [
                    'nama' => 'Karyawan Magang',
                    'status' => 'Aktif',
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]
            ]
        );
    }
}
