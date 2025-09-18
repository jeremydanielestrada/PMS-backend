<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectMemberController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\SubTaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\isAdmin;


//Public routes
Route::controller(AuthController::class)->group(function (){
    Route::post('/register','register')->name('user.register');
    Route::post('/login','login')->name('user.login');
});
    Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');






///Protetected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('project-members', ProjectMemberController::class);
    Route::apiResource('tasks',TaskController::class);
    Route::apiResource('subtasks',SubTaskController::class);
    Route::get('/users',[UserController::class,'index']);
});





