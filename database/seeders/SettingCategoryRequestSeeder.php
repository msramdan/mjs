<?php

namespace Database\Seeders;

use App\Models\Master\SettingCategoryRequest;
use Illuminate\Database\Seeder;

class SettingCategoryRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingCategoryRequest::insert([
            [
                'category_request_id' => 1,
                'user_id' => 2,
                'step' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ],
            [
                'category_request_id' => 1,
                'user_id' => 3,
                'step' => 2,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]
        ]);
    }
}
