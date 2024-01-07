<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Models\Project;


class AddMemberController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AddMemberRequest $request, Project $project)
    {
        $userId = $request->member_id;

        // Check if the user is already associated with the team
        if ($project->users()->where('user_id', $userId)->exists()) {
            return response()->json([
                'message' => 'User is already associated with the team.',
            ], 422);
        }

        // Use syncWithoutDetaching to ensure uniqueness
        $project->users()->syncWithoutDetaching([$userId => [
            'created_at' => now(),
            'updated_at' => now()
        ]]);

        return response()->json([
            'message' => 'Member added to project successfully!'
        ]);
    }
}