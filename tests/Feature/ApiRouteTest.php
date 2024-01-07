<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_throw_error_when_update_user_team_with_non_existing_user(): void
    {
        $userId = 1;

        $response = $this->patch("api/v1/users/{$userId}/team");

        $response->assertStatus(404);
        $response->assertJson(['message' => 'User not found.']);
    }

    public function test_update_user_team_with_existing_user(): void
    {
        Team::create([
            'name' => 'Dummy Team'
        ]);

        Team::create([
            'name' => 'Dummy Team 2'
        ]);

        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'city' => 'San Bernadino',
            'state' => 'California',
            'country' => 'America',
            'team_id' => 1
        ]);

        $requestData = [
            'team_id' => 2
        ];

        $response = $this->patch("api/v1/users/{$user->id}/team", $requestData);

        $response->assertStatus(200);

        $team = Team::find(2);
        $this->assertEquals('Dummy Team 2', $team->name);
    }

    public function test_throw_error_when_fetch_all_team_members_for_non_existing_team(): void
    {
        $teamId = 1;

        $response = $this->get("api/v1/teams/{$teamId}/members");

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Team not found.']);
    }
}