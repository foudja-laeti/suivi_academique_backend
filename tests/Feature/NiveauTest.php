<?php

namespace Tests\Feature;

use App\Models\Filiere;
use App\Models\Niveau;
use Tests\TestCase;
use Tests\Traits\ApiTokenTrait;

class NiveauTest extends TestCase
{
    use ApiTokenTrait;

    /** @test */
    public function test_create_niveau()
    {
        $filiere = Filiere::factory()->create();

        $niveauData = [
            'label_niveau' => 'Niveau Test',
            'desc_niveau' => 'Description du niveau test',
            'code_filiere' => $filiere->code_filiere,
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->postJson('/api/niveaux', $niveauData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'code_niveau',
                    'label_niveau',
                    'desc_niveau',
                    'code_filiere',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /** @test */
    public function test_update_niveau()
    {
        $filiere = Filiere::factory()->create();
        $niveau = Niveau::factory()->create([
            'code_filiere' => $filiere->code_filiere,
        ]);

        $updateData = [
            'label_niveau' => 'Niveau Mis à Jour',
            'desc_niveau' => 'Description mise à jour',
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->putJson("/api/niveaux/{$niveau->code_niveau}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'label_niveau' => 'Niveau Mis à Jour',
                'desc_niveau' => 'Description mise à jour',
            ]);
    }

    /** @test */
    public function test_delete_niveau()
    {
        $filiere = Filiere::factory()->create();
        $niveau = Niveau::factory()->create([
            'code_filiere' => $filiere->code_filiere,
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->deleteJson("/api/niveaux/{$niveau->code_niveau}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Suppression du niveau réussie']);
    }
}
