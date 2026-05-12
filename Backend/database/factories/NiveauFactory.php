<?php

namespace Database\Factories;

use App\Models\Filiere;
use App\Models\Niveau;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Niveau>
 */
class NiveauFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label_niveau' => $this->faker->words(1, true),
            'desc_niveau' => $this->faker->words(1, true),
            'code_filiere' => Filiere::factory(), // ✅
        ];
    }
}
