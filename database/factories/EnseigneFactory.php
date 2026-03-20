<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseigne>
 */
class EnseigneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'code_ec'   => \App\Models\Ec::factory(),        // ✅
        'code_pers' => \App\Models\Personnel::factory(), // ✅
    ];
}
}
