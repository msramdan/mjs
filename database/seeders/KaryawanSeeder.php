<?php

namespace Database\Seeders;

use App\Models\Legal\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Karyawan::create(
            [
                'divisi_id' => 1,
                'jabatan_id' => 1,
                'status_karyawan_id' => 1,
                'lokasi_id' => 1,
                'nama' => 'Bruno Bucciarati',
                'email' => 'bruno@gmail.com',
                'nik' => '317123123123',
                'alamat' => 'Bekasi',
                'gaji_pokok' => '8200000',
                'tgl_masuk' => '2020-08-22',
                'jenis_kelamin' => 'Laki-laki',
                'status_kawin' => 'Belum Menikah',
                'status_keaktifan' => 'Masih Bekerja',
            ]
        );
    }
}
