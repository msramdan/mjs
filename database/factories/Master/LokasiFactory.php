<?php

namespace Database\Factories\Master;

use App\Models\Master\Lokasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class LokasiFactory extends Factory
{
    protected $model = Lokasi::class;

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
