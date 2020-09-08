<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function createNewMessage()
    {
        $response = $this->json('POST', 'api/send-message');
        $response->assertStatus(422);

        for ($i = 0; $i < config('app.max_messages_count', 10); $i++) {
            $response = $this->json('POST', 'api/send-message', ['message' => 'Testing...']);
            $response->assertStatus(200);
        }

        $response = $this->json('POST', 'api/send-message', ['message' => 'Testing...']);
        $response->assertStatus(422);

        sleep(60);

        for ($i = 0; $i <= 30; $i++) {
            $response = $this->json('POST', 'api/send-message');
        }
        $response->assertStatus(429);
    }
}
