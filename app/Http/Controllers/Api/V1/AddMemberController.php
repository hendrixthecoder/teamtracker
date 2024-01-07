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
        $project->users()->attach($request->member_id, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Member added to project successfully!'
        ]);
    }
}