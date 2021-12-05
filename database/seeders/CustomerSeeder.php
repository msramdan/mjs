<?php

namespace Database\Seeders;

use App\Models\Contact\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    protected $model = Customer::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->count(15)->create();
    }
}
