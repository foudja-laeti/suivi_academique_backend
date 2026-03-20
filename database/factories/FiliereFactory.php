<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filiere>
 */
class FiliereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_filiere' => $this->faker->unique()->bothify('FILIERE###'),
           'label_filiere' => $this->faker->lexify('Filiere_????'), // ✅ toujours 12 chars
            'desc_filiere' => $this->faker->sentence(),
        ];
    }
}
