<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchTeamRequest;
use App\Http\Resources\UserResource;
use App\Models\Team;


class FetchUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Team $team)
    {
        return UserResource::collection($team->users);
    }
}