<?php

namespace Database\Factories;

use App\Models\Niveau;
use App\Models\Ue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ue>
 */
class UeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_ue' => $this->faker->unique()->bothify('UE###'),
            'label_ue' => $this->faker->words(1, true),
            'desc_ue' => $this->faker->sentence(),
            'code_niveau' => Niveau::factory(),
        ];
    }
}
