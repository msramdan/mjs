<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunGrupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_group')->insert([
            [
                'account_group' => 'ASSET',
                'report' => 'BS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'LIABILITIES',
                'report' => 'BS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'EQUITY',
                'report' => 'BS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'REVENUE',
                'report' => 'IS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'EXPENSE',
                'report' => 'IS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'GAIN',
                'report' => 'IS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'LOSS',
                'report' => 'IS',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
        ]);
    }
}
