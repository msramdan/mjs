<?php

namespace Database\Factories\Contact;

use App\Models\Contact\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode' => $this->faker->bothify('SUP-#####'),
            'nama' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'alamat' => $this->faker->address(),
            'kota' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
            'telp' => $this->faker->phoneNumber(),
            'personal_kontak' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'kode_pos' => $this->faker->postcode(),
            'catatan' => $this->faker->sentence(6),
        ];
    }
}
