<?php

namespace Database\Factories;

use App\Models\Salle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Salle>
 */
class SalleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'num_salle' => $this->faker->unique()->bothify('CF###'),
            'contenance' => $this->faker->randomDigit(),
            'status' => $this->faker->randomElement(['Disponible', 'Indisponible']),
        ];
    }
}
