<?php

namespace Database\Factories\Master;

use App\Models\Master\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => ucfirst($this->faker->word()),
            'status' => 'Aktif',
        ];
    }
}
