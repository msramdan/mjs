<?php

namespace Database\Factories\ElectronicDocument;

use App\Models\ElectronicDocument\CategoryDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryDocumentFactory extends Factory
{
    protected $model = CategoryDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => ucfirst($this->faker->word())
        ];
    }
}
