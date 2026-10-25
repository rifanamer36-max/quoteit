<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationRulesTest extends TestCase
{
    use RefreshDatabase;

    private function data(array $extra = []): array
    {
        return array_merge(['name' => 'Sara Ali', 'email' => 'sara@example.com', 'password' => 'password123'], $extra);
    }

    public function test_user_can_register_with_a_valid_email(): void
    {
        $this->post('/register', $this->data())->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', ['email' => 'sara@example.com']);
    }

    public function test_invalid_email_is_rejected(): void
    {
        foreach (['sara', 'sara@', '@example.com', 'sara example.com'] as $bad) {
            $this->post('/register', $this->data(['email' => $bad]))->assertSessionHasErrors('email');
        }

        $this->assertDatabaseCount('users', 0);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'sara@example.com']);

        $this->post('/register', $this->data())->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }
}