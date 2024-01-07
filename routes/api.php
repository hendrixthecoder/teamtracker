<?php

use App\Http\Controllers\Api\V1\AddMemberController;
use App\Http\Controllers\Api\V1\FetchProjectMembers;
use App\Http\Controllers\Api\V1\FetchUserController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\UpdateTeamController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResource('/teams', TeamController::class);
    Route::apiResource('/projects', ProjectController::class);
    Route::apiResource('/users', UserController::class);

    Route::patch('/users/{user}/team', UpdateTeamController::class)
        ->missing(function () {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        });

    Route::get('/teams/{team}/members', FetchUserController::class)
        ->missing(function () {
            return response()->json([
                'message' => 'Team not found.'
            ], 404);
        });;

    Route::prefix('projects')->group(function () {
        Route::post('/{project}/add_member', AddMemberController::class)
            ->missing(function () {
                return response()->json([
                    'message' => 'Project not found.'
                ], 404);
            });

        Route::get('/{project}/members', FetchProjectMembers::class)
            ->missing(function () {
                return response()->json([
                    'message' => 'Project not found.'
                ], 404);
            });
    });
});