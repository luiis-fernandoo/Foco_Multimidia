<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Rooms;
use Tests\TestCase;

class ApiTestUpdate extends TestCase
{
    /**
     * A basic test example.
     */
    public function testApiUpdate(): void
    {
        $data = [
            'roomName' => 'Novo Nome do Quarto'
        ];

        // Supondo que você tenha um quarto existente no banco de dados com um ID específico
        $roomId = 1;

        // Chame a rota de atualização /api/hotels/{id} substituindo {id} pelo ID do quarto
        $response = $this->json('PUT', '/api/hotels/' . $roomId, $data);

        // Verifique se a resposta tem o status esperado
        $response->assertStatus(200);

        // Verifique se o quarto foi atualizado no banco de dados
        $updatedRoom = Rooms::find($roomId);
        $this->assertEquals($data['roomName'], $updatedRoom->roomName);

        // Verifique se a resposta contém o quarto atualizado
        $response->assertJson(['room' => $updatedRoom->toArray()]);
    }
}
