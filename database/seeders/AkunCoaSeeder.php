<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunCoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_coa')->insert([
            [
                'kode' => 'COA001',
                'nama' => 'COA 1',
                'account_header_id' => 1,
                'normal' => 'Praesent sapien massa',
                'remark' => 'Nulla porttitor accumsan tincidunt'
            ],
            [
                'kode' => 'COA002',
                'nama' => 'COA 2',
                'account_header_id' => 2,
                'normal' => 'Nulla porttitor accumsan',
                'remark' => 'Pellentesque in ipsum'
            ],
        ]);
    }
}
