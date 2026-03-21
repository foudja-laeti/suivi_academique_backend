<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Personnel;
use Tests\Traits\ApiTokenTrait;

class PersonnelTest extends TestCase
{
    use ApiTokenTrait;

    /** @test */
    public function test_create_personnel()
    {
        $personnelData = [
    'code_pers'  => 'PERS101',
    'nom_pers'   => 'Jean Dupont',
    'sexe_pers'  => 'Masculin',
    'phone_pers' => '690123456',
    'login_pers' => 'jeandupont',
    'pwd_pers'   => 'password123',
    'type_pers'  => 'ENSEIGNANT', // ✅ valeur valide
];

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->postJson('/api/personnels', $personnelData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'id',
                         'code_pers',
                         'nom_pers',
                         'sexe_pers',
                         'phone_pers',
                         'login_pers',
                         'pwd_pers',
                         'type_pers',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }

    /** @test */
    public function test_update_personnel()
    {
        $personnel = Personnel::factory()->create();

        $updateData = [
            'nom_pers'  => 'Jean Mis à Jour',
            'sexe_pers' => 'Feminin',
            'type_pers' => 'Utilisateur',
        ];

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->putJson("/api/personnels/{$personnel->id}", $updateData);


        dump($response->json());

$response->assertStatus(200);
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'nom_pers'  => 'Jean Mis à Jour',
                     'sexe_pers' => 'Feminin',
                     'type_pers' => 'ENSEIGNANT',
                 ]);
    }

    /** @test */
    public function test_show_personnel()
    {
        $personnel = Personnel::factory()->create();

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->getJson("/api/personnels/{$personnel->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'code_pers',
                         'nom_pers',
                         'sexe_pers',
                         'phone_pers',
                         'login_pers',
                         'pwd_pers',
                         'type_pers',
                         'created_at',
                         'updated_at',
                     ]
                 ]);
    }

    /** @test */
    public function test_delete_personnel()
    {
        $personnel = Personnel::factory()->create();

        $response = $this->withHeaders($this->withApiTokenHeaders())
                         ->deleteJson("/api/personnels/{$personnel->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Personnel supprimé avec succès']);
    }
}
