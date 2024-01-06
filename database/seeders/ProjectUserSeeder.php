<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::find(1)
            ->users()
            ->attach(
                1,
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
    }
}
