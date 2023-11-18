<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'companyname' => $this->faker->words($nb = rand(2, 3), $asText = true),
            'email' => $this->faker->unique()->email,
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->words($nb = rand(3, 4), $asText = true),
            'active' => 1,
        ];
    }
}
