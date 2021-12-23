<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_header')->insert([
            [
                'kode' => 'HEAD001',
                'nama' => 'Header 1',
                'account_group_id' => 1
            ],
            [
                'kode' => 'HEAD002',
                'nama' => 'Header 2',
                'account_group_id' => 2
            ],
        ]);
    }
}
