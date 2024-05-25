<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TokenControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testStore(): void
    {
        $email = fake()->safeEmail;
        $password = fake()->password;

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $encodedString = base64_encode(sprintf('%s:%s', $email, $password));

        $response = $this->post('/api/v1/tokens', headers: [
            'Authorization' => 'Basic '.$encodedString,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
