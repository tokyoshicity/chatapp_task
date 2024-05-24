<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->chat = Chat::factory()->create();

        Sanctum::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $uri = sprintf('/api/v1/chats/%s/messages', $this->chat->id);
        $response = $this->get($uri);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore(): void
    {
        $uri = sprintf('/api/v1/chats/%s/messages', $this->chat->id);
        $response = $this->post($uri, [
            'body' => fake()->text,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
