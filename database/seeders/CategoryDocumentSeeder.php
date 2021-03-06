<?php

namespace Database\Seeders;

use App\Models\ElectronicDocument\CategoryDocument;
use Illuminate\Database\Seeder;

class CategoryDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryDocument::factory()->count(3)->create();
    }
}
