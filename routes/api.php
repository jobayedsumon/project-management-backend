<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('developers', DeveloperController::class);
    Route::post('developers/{developer}/assign-projects', [DeveloperController::class, 'assignProjects']);
    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/assign-developers', [ProjectController::class, 'assignDevelopers']);
});
