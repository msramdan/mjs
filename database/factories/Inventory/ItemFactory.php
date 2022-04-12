<?php

namespace Database\Factories\Inventory;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => random_int(1, 3),
            'unit_id' => random_int(1, 3),
            'kode' => $this->faker->unique()->randomNumber(5),
            'nama' => $this->faker->name(),
            'type' => $this->faker->randomElement(['Consumable', 'Services']),
            'deskripsi' => 'tes',
            'stok' => 0,
            'foto' => '1644558359.png',
            'harga_estimasi' => random_int(10000, 999999)
        ];
    }
}
