<?php

namespace Tests\Feature;

use App\Models\Ec;
use App\Models\Enseigne;
use App\Models\Personnel;
use Tests\TestCase;
use Tests\Traits\ApiTokenTrait;

class EnseigneTest extends TestCase
{
    use ApiTokenTrait;

    public function test_create_enseigne()
    {
        $personnel = Personnel::factory()->create();
        $ec = Ec::factory()->create();

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->postJson('/api/enseignes', [
                'code_pers' => $personnel->code_pers,
                'code_ec' => $ec->code_ec,
                'date_ens' => now()->toDateString(),
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'code_pers',
                    'code_ec',
                    'date_ens',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_update_enseigne()
    {
        $personnel = Personnel::factory()->create();
        $ec = Ec::factory()->create();

        $enseigne = Enseigne::create([
            'code_pers' => $personnel->code_pers,
            'code_ec' => $ec->code_ec,
            'date_ens' => now()->subDay()->toDateString(),
        ]);

        $updateData = [
            'date_ens' => now()->toDateString(),
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->putJson("/api/enseignes/{$enseigne->code_pers}/{$enseigne->code_ec}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'date_ens' => $updateData['date_ens'],
            ]);
    }

    public function test_delete_enseigne()
    {
        $personnel = Personnel::factory()->create();
        $ec = Ec::factory()->create();

        $enseigne = Enseigne::create([
            'code_pers' => $personnel->code_pers,
            'code_ec' => $ec->code_ec,
            'date_ens' => now()->toDateString(),
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->deleteJson("/api/enseignes/{$enseigne->code_pers}/{$enseigne->code_ec}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Enseigne supprimée avec succès']);
    }
}
