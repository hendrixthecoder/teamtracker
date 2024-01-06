<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;


class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TeamResource::collection(Team::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $team = Team::create($request->validated());
        return TeamResource::make($team);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return TeamResource::make($team);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team->update($request->validated());
        return TeamResource::make($team);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return response()->noContent();
    }
}