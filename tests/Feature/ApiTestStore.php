<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTestStore extends TestCase
{
    /**
     * A basic test example.
     */
    public function testStoreHotel()
    {
        $response = $this->json('POST', '/api/hotels', ['hotelsName' => 'Hotel Test']);
        $response->assertStatus(200)
            ->assertJson(['message' => 'hotel cadastrado']);
    }

    public function testStoreRoom()
    {
        $rooms = [
            ['roomName' => 'Room 1', 'hotelCode' => '1'],
            ['roomName' => 'Room 2', 'hotelCode' => '1'],
        ];

        $response = $this->json('POST', '/api/hotels', ['rooms' => $rooms]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Quarto Cadastrado']);
    }


}
