<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Ue;
use App\Models\Niveau;
use Tests\Traits\ApiTokenTrait;

class UeTest extends TestCase
{
    use ApiTokenTrait;

    /** @test */
    public function test_create_ue()
    {
        // Crée un niveau car code_niveau est requis
        $niveau = Niveau::factory()->create();

        $ueData = [
            'code_ue' => 'UE101',
            'label_ue' => 'UE Test',
            'desc_ue' => 'Description UE test',
            'code_niveau' => $niveau->code_niveau,
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->postJson('/api/Ue', $ueData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'code_ue',
                         'label_ue',
                         'desc_ue',
                         'code_niveau',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }

    /** @test */
    public function test_update_ue()
    {
        $niveau = Niveau::factory()->create();
        $ue = Ue::factory()->create([
            'code_niveau' => $niveau->code_niveau,
        ]);

        $updateData = [
            'label_ue' => 'UE Mis à Jour',
            'desc_ue' => 'Description mise à jour',
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->putJson("/api/Ue/{$ue->code_ue}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'label_ue' => 'UE Mis à Jour',
                     'desc_ue' => 'Description mise à jour',
                 ]);
    }

    /** @test */
    public function test_show_ue()
    {
        $niveau = Niveau::factory()->create();
        $ue = Ue::factory()->create([
            'code_niveau' => $niveau->code_niveau,
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->getJson("/api/Ue/{$ue->code_ue}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'code_ue',
                         'label_ue',
                         'desc_ue',
                         'code_niveau',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }

    /** @test */
    public function test_delete_ue()
    {
        $niveau = Niveau::factory()->create();
        $ue = Ue::factory()->create([
            'code_niveau' => $niveau->code_niveau,
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->deleteJson("/api/Ue/{$ue->code_ue}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'UE supprimé avec succès']);
    }
}
