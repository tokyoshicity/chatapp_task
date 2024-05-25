<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get('/api/v1/chats');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore(): void
    {
        $response = $this->post('/api/v1/chats', [
            'userId' => User::factory()->create()->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
