<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
        $response = $this->get('/api/v1/users');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testStore(): void
    {
        $response = $this->post('/api/v1/users', [
            'firstName' => fake()->firstName,
            'lastName' => fake()->lastName,
            'email' => fake()->safeEmail,
            'password' => fake()->password,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
