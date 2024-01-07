<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserTeamRequest;
use App\Http\Resources\UserResource;
use App\Models\User;


class UpdateTeamController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateUserTeamRequest $request, User $user)
    {
        $user->update($request->all());

        return UserResource::make($user);
    }
}