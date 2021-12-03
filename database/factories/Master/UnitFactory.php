<?php

namespace Database\Factories\Master;

use App\Models\Master\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

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
