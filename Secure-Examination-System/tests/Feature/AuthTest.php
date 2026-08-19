<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/register', [
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => 'password123',
            'role' => 'student',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'student@test.com']);
    }

    public function test_user_can_login_and_generate_otp()
    {
        $user = User::factory()->create([
            'email' => 'student@test.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'student@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'debug_otp']);
    }
}
