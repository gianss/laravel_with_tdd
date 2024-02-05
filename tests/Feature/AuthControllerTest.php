<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;

class IntegrationAuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Unauthorized']);
    }

    public function testLoginWithMissingEmail()
    {
        $response = $this->postJson('/api/login', [
            'password' => 'somepassword',
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'O campo de email é obrigatório.']);
    }

    public function testLoginWithMissingPassword()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'O campo de password é obrigatório.']);
    }
}
