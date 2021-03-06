<?php

namespace Database\Seeders;

use App\Models\Master\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::factory()->count(5)->create();

        Jabatan::create(['nama' => 'General Manager(GM)', 'status' => 'Aktif']);
        Jabatan::create(['nama' => 'Direktur', 'status' => 'Aktif']);
    }
}
