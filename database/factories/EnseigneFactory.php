<?php

namespace Database\Factories;

use App\Models\Ec;
use App\Models\Enseigne;
use App\Models\Personnel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Enseigne>
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
            'id' => (string) Str::uuid(), // ✅
            'code_pers' => Personnel::factory(),
            'code_ec' => Ec::factory(),
            'date_ens' => now()->toDateString(),
        ];
    }
}
