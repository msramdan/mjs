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
                'report' => 'Balance Sheet',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'LIABILITIES',
                'report' => 'Balance Sheet',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'EQUITY',
                'report' => 'Balance Sheet',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'REVENUE',
                'report' => 'Income Statment',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'EXPENSE',
                'report' => 'Income Statment',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'GAIN',
                'report' => 'Income Statment',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'account_group' => 'LOSS',
                'report' => 'Income Statment',
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
        ]);
    }
}
