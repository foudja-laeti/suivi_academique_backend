<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Salle;
use Tests\Traits\ApiTokenTrait;

class SalleTest extends TestCase
{
    use ApiTokenTrait;

    /** @test */
    public function test_create_salle()
    {
        $salleData = [
            'num_salle' => 'SALLE101',
            'contenance' => 50,
            'status' => 'Disponible',
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->postJson('/api/salles', $salleData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'num_salle',
                         'contenance',
                         'status',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }

    /** @test */
    public function test_update_salle()
    {
        $salle = Salle::factory()->create([
            'num_salle' => 'SALLE102',
            'contenance' => 40,
            'status' => 'Disponible',
        ]);

        $updateData = [
            'contenance' => 60,
            'status' => 'Indisponible',
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->putJson("/api/salles/{$salle->num_salle}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'contenance' => 60,
                     'status' => 'Indisponible',
                 ]);
    }

    /** @test */
    public function test_show_salle()
    {
        $salle = Salle::factory()->create([
            'num_salle' => 'SALLE103',
            'contenance' => 30,
            'status' => 'Disponible',
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->getJson("/api/salles/{$salle->num_salle}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'num_salle',
                         'contenance',
                         'status',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }

    /** @test */
    public function test_delete_salle()
    {
        $salle = Salle::factory()->create([
            'num_salle' => 'SALLE104',
            'contenance' => 25,
            'status' => 'Disponible',
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->deleteJson("/api/salles/{$salle->num_salle}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Salle supprimée avec succès']);
    }
}
