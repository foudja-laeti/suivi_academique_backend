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
        'id'       => (string) \Illuminate\Support\Str::uuid(), // ✅
        'code_pers' => \App\Models\Personnel::factory(),
        'code_ec'   => \App\Models\Ec::factory(),
        'date_ens'  => \Illuminate\Support\Facades\Date::now()->toDateString(),
    ];
}
}
