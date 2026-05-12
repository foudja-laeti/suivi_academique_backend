<?php

namespace Tests\Feature;

use App\Models\Ec;
use App\Models\Ue;
use Tests\TestCase;
use Tests\Traits\ApiTokenTrait;

class EcTest extends TestCase
{
    use ApiTokenTrait;

    /** @test */
    public function test_create_ec()
    {
        $ue = Ue::factory()->create();

        $ecData = [
            'code_ec' => 'EC101',
            'label_ec' => 'EC Test',
            'desc_ec' => 'Description EC test',
            'nbh_ec' => 20,
            'nbc_ec' => 30,
            'code_ue' => $ue->code_ue,
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->postJson('/api/ec', $ecData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'code_ec',
                    'label_ec',
                    'desc_ec',
                    'nbh_ec',
                    'nbc_ec',
                    'code_ue',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /** @test */
    public function test_update_ec()
    {
        $ue = Ue::factory()->create();
        $ec = Ec::factory()->create([
            'code_ue' => $ue->code_ue,
        ]);

        $updateData = [
            'label_ec' => 'EC Mis à Jour',
            'desc_ec' => 'Description mise à jour',
            'nbh_ec' => 25,
            'nbc_ec' => 35,
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->putJson("/api/ec/{$ec->code_ec}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'label_ec' => 'EC Mis à Jour',
                'desc_ec' => 'Description mise à jour',
                'nbh_ec' => 25,
                'nbc_ec' => 35,
            ]);
    }

    /** @test */
    public function test_show_ec()
    {
        $ue = Ue::factory()->create();
        $ec = Ec::factory()->create([
            'code_ue' => $ue->code_ue,
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->getJson("/api/ec/{$ec->code_ec}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'code_ec',
                    'label_ec',
                    'desc_ec',
                    'nbh_ec',
                    'nbc_ec',
                    'code_ue',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /** @test */
    public function test_delete_ec()
    {
        $ue = Ue::factory()->create();
        $ec = Ec::factory()->create([
            'code_ue' => $ue->code_ue,
        ]);

        $response = $this->withHeaders($this->withApiTokenHeaders())
            ->deleteJson("/api/ec/{$ec->code_ec}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'EC supprimé avec succès']);
    }
}
