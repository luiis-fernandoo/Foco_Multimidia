<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Reserves;
use App\Models\Rooms;
use Tests\TestCase;

class ApiTestDestroy extends TestCase
{
    /**
     * A basic test example.
     */
    public function testApiDestroy(): void
    {
        // Suponha que você tenha um quarto existente no banco de dados com um ID específico
        $roomId = 1;

        // Chame a rota de exclusão /api/hotels/{id}?type=room substituindo {id} pelo ID do quarto
        $response = $this->json('DELETE', '/api/hotels/' . $roomId . '?type=room');

        // Verifique se a resposta tem o status esperado
        $response->assertStatus(200);

        // Verifique se o quarto foi removido do banco de dados
        $this->assertNull(Rooms::find($roomId));

        // Verifique se a resposta contém a mensagem esperada
        $response->assertJson(['message' => 'Deletado com sucesso']);
    }

    public function testDestroyReserve()
    {
        // Suponha que você tenha uma reserva existente no banco de dados com um ID específico
        $reserveId = 1;

        // Chame a rota de exclusão /api/hotels/{id}?type=reserves substituindo {id} pelo ID da reserva
        $response = $this->json('DELETE', '/api/hotels/' . $reserveId . '?type=reserves');

        // Verifique se a resposta tem o status esperado
        $response->assertStatus(200);

        // Verifique se a reserva foi removida do banco de dados
        $this->assertNull(Reserves::find($reserveId));

        // Verifique se a resposta contém a mensagem esperada
        $response->assertJson(['message' => 'Deletado com sucesso']);
    }

    public function testDestroyNonExistingRoom()
    {
        // Suponha que você esteja tentando excluir um quarto que não existe no banco de dados
        $nonExistingRoomId = 100;

        // Chame a rota de exclusão /api/hotels/{id}?type=room substituindo {id} pelo ID do quarto
        $response = $this->json('DELETE', '/api/hotels/' . $nonExistingRoomId . '?type=room');

        // Verifique se a resposta tem o status esperado
        $response->assertStatus(200);

        // Verifique se a resposta contém a mensagem esperada para um quarto não encontrado
        $response->assertJson(['message' => 'Quarto não encontrado']);
    }

    public function testDestroyNonExistingReserve()
    {
        // Suponha que você esteja tentando excluir uma reserva que não existe no banco de dados
        $nonExistingReserveId = 100;

        // Chame a rota de exclusão /api/hotels/{id}?type=reserves substituindo {id} pelo ID da reserva
        $response = $this->json('DELETE', '/api/hotels/' . $nonExistingReserveId . '?type=reserves');

        // Verifique se a resposta tem o status esperado
        $response->assertStatus(200);

        // Verifique se a resposta contém a mensagem esperada para uma reserva não encontrada
        $response->assertJson(['message' => 'Reserva não encontrada']);
    }
    
}


