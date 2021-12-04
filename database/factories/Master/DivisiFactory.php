<?php

namespace Database\Factories\Master;

use App\Models\Master\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DivisiFactory extends Factory
{
    protected $model = Divisi::class;

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
