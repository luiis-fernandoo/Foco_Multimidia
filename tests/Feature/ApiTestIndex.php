<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTestIndex extends TestCase
{
    /**
     * A basic test example.
     */
    public function testApiIndex(): void
    {
        $response = $this->json('GET', '/api/hotels');

        $response->assertStatus(200)->
        assertJsonStructure([
            'hotels' =>[ '*' =>[
                    'id',
                    'created_at',
                    'updated_at',
                    'hotelsName',
                ]
            ]
                        
        ]);
    }

}
