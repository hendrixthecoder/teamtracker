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
    
    public function test_fetch_all_team_members_for_existing_team(): void
    {
        $team = Team::create([
            'name' => 'Dummy Team'
        ]);

        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'city' => 'San Bernadino',
            'state' => 'California',
            'country' => 'America',
            'team_id' => $team->id
        ]);

        $response = $this->get("api/v1/teams/{$team->id}/members");

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'city' => $user->city,
                'state' => $user->state,
                'country' => $user->country,
            ]);
    }

    public function test_throw_error_when_add_member_to_non_existing_project(): void
    {
        $projectId = 1;
        
        $response = $this->post("api/v1/projects/{$projectId}/add_member");
        $response->assertStatus(404);
        $response->assertJson(['message' => 'Project not found.']);
    }

    
}