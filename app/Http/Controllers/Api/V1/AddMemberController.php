<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Models\Project;
use App\Models\User;

class AddMemberController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AddMemberRequest $request, Project $project)
    {
        $user = User::find($request->member_id);
        
        // Check if project belongs to user's team
        if($user->team->id != $project->team->id){
            return response()->json(['message' => 'Project is not for member\'s team.'], 403);
        }

        // Check if the user is already associated with the team
        if ($project->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Member is already associated with the team.',
            ], 422);
        }

        // Use syncWithoutDetaching to ensure uniqueness
        $project->users()->syncWithoutDetaching([
            $user->id => [
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        return response()->json([
            'message' => 'Member added to project successfully!'
        ]);
    }
}