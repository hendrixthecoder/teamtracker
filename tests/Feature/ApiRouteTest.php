<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRouteTest extends TestCase
{
    use RefreshDatabase;

    protected $team;
    protected $team2;
    protected $user;
    protected $project;

    public function setUp(): void
    {
        parent::setUp();

        $this->team = Team::create(['name' => 'Dummy Team']);
        $this->team2 = Team::create(['name' => 'Dummy Team 2']);
        $this->user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'city' => 'San Bernadino',
            'state' => 'California',
            'country' => 'America',
            'team_id' => $this->team->id,
        ]);
        $this->project = Project::create(['name' => 'Dummy project', 'team_id' => $this->team->id]);
    }

    public function test_throw_error_when_update_user_team_with_non_existing_user(): void
    {
        $userId = 200;

        $requestData = [
            'team_id' => $this->team->id
        ];

        $response = $this->patch("api/v1/users/{$userId}/team", $requestData);

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'User not found.']);
    }

    public function test_update_user_team_with_existing_user(): void
    {
        $requestData = [
            'team_id' => $this->team2->id
        ];

        $response = $this->patch("api/v1/users/{$this->user->id}/team", $requestData);

        $response->assertStatus(200);

        $this->assertEquals('Dummy Team 2', $this->team2->name);
    }

    public function test_throw_error_when_fetch_all_team_members_for_non_existing_team(): void
    {
        $teamId = 1;

        $response = $this->get("api/v1/teams/{$teamId}/members");

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'Team not found.']);
    }

    public function test_fetch_all_team_members_for_existing_team(): void
    {
        $response = $this->get("api/v1/teams/{$this->team->id}/members");

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'city' => $this->user->city,
                'state' => $this->user->state,
                'country' => $this->user->country,
            ]);
    }

    public function test_throw_error_when_add_member_to_non_existing_project(): void
    {
        $projectId = 1;

        $response = $this->post("api/v1/projects/{$projectId}/add_member");
        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'Project not found.']);
    }

    public function test_add_member_to_existing_project(): void
    {
        $requestData = [
            'member_id' => $this->user->id
        ];

        $response = $this->post("api/v1/projects/{$this->project->id}/add_member", $requestData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('project_user', [
            'project_id' => $this->project->id,
            'user_id' => $this->user->id
        ]);
    }

    public function test_throw_error_when_try_to_fetch_members_of_non_existing_project()
    {
        $projectId = 1;

        $response = $this->get("api/v1/projects/{$projectId}/members");
        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'Project not found.']);
    }

    public function test_fetch_members_of_existing_project()
    {
        $requestData = [
            'member_id' => $this->user->id
        ];

        $this->post("api/v1/projects/{$this->project->id}/add_member", $requestData);

        $response = $this->get("api/v1/projects/{$this->project->id}/members");
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'city' => $this->user->city,
                'state' => $this->user->state,
                'country' => $this->user->country,
            ]);
    }

    public function test_fetch_all_teams_endpoint_works()
    {
        $response = $this->get("api/v1/teams");
        
        $response
            ->assertStatus(200)
            ->assertJsonFragment(
                ['name' => 'Dummy Team'], 
                ['name' => 'Dummy Team 2']
            );
    }

    public function test_create_new_team_endpoint_works()
    {
        $requestData = [
            'name' => 'New Team'
        ];
        
        $response = $this->post("api/v1/teams", $requestData);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([ "name" => "New Team"]);

        $this->assertDatabaseHas("teams", $requestData);

    }

    public function test_fetch_one_team_endpoint_works()
    {
        $response = $this->get("api/v1/teams/{$this->team->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(
                ["name" => "Dummy Team"]
            );
    }

    public function test_update_endpoint_works()
    {
        $requestData = [
            'name' => 'Dummy Team Updated'
        ];

        $response = $this->patch("api/v1/teams/{$this->team->id}", $requestData);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Dummy Team Updated'
            ]);
    }

    public function test_delete_team_endpoint_works()
    {
        $response = $this->delete("api/v1/teams/{$this->team->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('teams', ['id' => $this->team->id]);
    }

    public function test_fetch_all_projects_endpoint_works()
    {
        $response = $this->get("api/v1/projects");

        $response
            ->assertStatus(200)
            ->assertJsonFragment(
                ['name' => 'Dummy project'],
            );
    }

    public function test_create_new_project_endpoint_works()
    {
        $requestData = [
            'name' => 'New Project',
            'team_id' => $this->team->id,
        ];

        $response = $this->post("api/v1/projects", $requestData);

        $response
            ->assertStatus(201)
            ->assertJsonFragment(["name" => "New Project"]);
            
        $this->assertDatabaseHas("projects", $requestData);
    }

    public function test_fetch_one_project_endpoint_works()
    {
        $response = $this->get("api/v1/projects/{$this->project->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(["name" => "Dummy project"]);
    }

    public function test_update_project_endpoint_works()
    {
        $requestData = [
            'name' => 'Dummy project Updated',
        ];

        $response = $this->patch("api/v1/projects/{$this->project->id}", $requestData);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Dummy project Updated',
            ]);
    }

    public function test_delete_project_endpoint_works()
    {
        $response = $this->delete("api/v1/projects/{$this->project->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('projects', ['id' => $this->project->id]);
    }

    public function test_fetch_all_users_endpoint_works()
    {
        $response = $this->get("api/v1/users");

        $response
            ->assertStatus(200)
            ->assertJsonFragment(
                ['first_name' => 'John', 'last_name' => 'Doe']
            );
    }

    public function test_create_new_user_endpoint_works()
    {
        $requestData = [
            'first_name' => 'New',
            'last_name' => 'User',
            'city' => 'New City',
            'state' => 'New State',
            'country' => 'New Country',
            'team_id' => $this->team->id,
        ];

        $response = $this->post("api/v1/users", $requestData);

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['first_name' => 'New', 'last_name' => 'User']);

        $this->assertDatabaseHas("users", $requestData);
    }

    public function test_fetch_one_user_endpoint_works()
    {
        $response = $this->get("api/v1/users/{$this->user->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['first_name' => 'John', 'last_name' => 'Doe']);
    }

}