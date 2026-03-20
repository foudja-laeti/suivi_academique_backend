<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Programmation>
 */
class ProgrammationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'id'          => (string) Str::uuid(),
        'code_ec'     => \App\Models\Ec::factory(),        // ✅
        'num_salle'   => \App\Models\Salle::factory(),     // ✅
        'code_pers'   => \App\Models\Personnel::factory()->create()->code_pers,
        'date'        => $this->faker->date(),
        'heure_debut' => $this->faker->time(),
        'heure_fin'   => $this->faker->time(),
        'nbre_heure'  => $this->faker->randomDigit(),
        'Status'      => $this->faker->randomElement(['Programmé', 'Annulé', 'Terminé']),
    ];
}
}
