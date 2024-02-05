<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use \App\Http\Controllers\Api\AuthController;
use \Illuminate\Http\Request;

class UnitAuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testLoginWithValidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $request = new Request([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $authController = new AuthController();
        $response = $authController->login($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('token', json_decode($response->getContent(), true));
    }

    public function testLoginWithInvalidCredentials()
    {
        $request = new Request([
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $authController = new AuthController();
        $response = $authController->login($request);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertArrayHasKey('error', json_decode($response->getContent(), true));
    }
}
