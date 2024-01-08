<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'name' => 'UI Updates',
            'team_id' => 1
        ]);
        
        Project::create([
            'name' => 'UI Updates Team 2',
            'team_id' => 2
        ]);
    }
}