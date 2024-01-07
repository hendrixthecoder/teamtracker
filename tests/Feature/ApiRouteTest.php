<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_user_team_with_non_existing_user(): void
    {
        $userId = 1;

        $response = $this->patch("api/v1/users/{$userId}/team");

        $response->assertStatus(404);
        $response->assertJson(['message' => 'User not found.']);
    }
}