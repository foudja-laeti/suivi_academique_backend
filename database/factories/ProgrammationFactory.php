<?php

namespace Database\Factories;

use App\Models\Ec;
use App\Models\Personnel;
use App\Models\Programmation;
use App\Models\Salle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Programmation>
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
            'id' => (string) Str::uuid(),
            'code_ec' => Ec::factory(),        // ✅
            'num_salle' => Salle::factory(),     // ✅
            'code_pers' => Personnel::factory()->create()->code_pers,
            'date' => $this->faker->date(),
            'heure_debut' => $this->faker->time(),
            'heure_fin' => $this->faker->time(),
            'nbre_heure' => $this->faker->randomDigit(),
            'Status' => $this->faker->randomElement(['Programmé', 'Annulé', 'Terminé']),
        ];
    }
}
