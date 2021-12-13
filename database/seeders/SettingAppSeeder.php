<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_app')->insert([
            [
                'nama_aplikasi' => 'PT. MJS - System',
                'nama_perusahaan' => 'PT Marindo Jaya Sejahtera',
                'alamat_perusahaan' => '3rd Floor, Bakri Tower, Komplek Rasuna Epicentrum, Jalan Haji R Rasuna Said, Kel Kuningan Timur, Jakarta, Indonesia',
                'nama_direktur' =>'Ir. Yani Yunus',
                'logo_perusahaan' =>'',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
