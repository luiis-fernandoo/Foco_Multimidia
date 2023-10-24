<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Dailies;
use App\Models\Guests;
use App\Models\Hotels;
use App\Models\Payments;
use App\Models\Reserves;
use App\Models\Rooms;
use Tests\TestCase;
use RefreshDatabase;

class ApiTestShow extends TestCase
{
    /**
     * A basic test example.
     */
    public function testApiShow(): void
    {

        $hotel = Hotels::factory()->create();
        $room = Rooms::factory()->create(['hotelCode' => $hotel->id]);
        $reserve = Reserves::factory()->create(['hotelCode' => $hotel->id, 'roomCode' => $room->id]);
        Guests::factory()->create(['reserves_id' => $reserve->id]);
        Dailies::factory()->create(['reserves_id' => $reserve->id]);
        Payments::factory()->create(['reserves_id' => $reserve->id]);

        // Mock do método join para evitar a interação com o banco de dados real
        $this->mock(Reserves::class, function ($mock) {
            $mock->shouldReceive('join')->andReturnSelf();
            $mock->shouldReceive('select')->andReturnSelf();
            $mock->shouldReceive('join')->andReturnSelf();
            $mock->shouldReceive('leftJoin')->andReturnSelf();
            $mock->shouldReceive('groupBy')->andReturnSelf();
            $mock->shouldReceive('where')->andReturnSelf();
            $mock->shouldReceive('get')->andReturn(collect([/* dados simulados */]));
        });

        $response = $this->json('GET', '/api/hotels/' . $hotel->id);

        // Verifique se a resposta tem o status esperado
        $response->assertStatus(200);

        // Verifique se a resposta contém a estrutura de dados esperada
        $response->assertJsonStructure(['rooms', 'reserves']);
    }
}
