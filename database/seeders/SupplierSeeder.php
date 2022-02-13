<?php

namespace Database\Seeders;

use App\Models\Contact\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    protected $model = Supplier::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::factory()->count(5)->create();
    }
}
