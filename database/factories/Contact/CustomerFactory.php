<?php

namespace Database\Factories\Contact;

use App\Models\Contact\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode' => $this->faker->bothify('CUS-#####'),
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
