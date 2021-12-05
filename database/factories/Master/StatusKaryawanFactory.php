<?php

namespace Database\Factories\Master;

use App\Models\Master\StatusKaryawan;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusKaryawanFactory extends Factory
{
    protected $model = StatusKaryawan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => ucfirst($this->faker->word(5)),
            'status' => 'Aktif',
        ];
    }
}
