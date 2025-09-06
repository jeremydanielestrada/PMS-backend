<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


//Public routes


Route::controller(AuthController::class)->group(function (){
    Route::post('/register','register')->name('user.register');
    Route::post('/login','login')->name('user.login');
    Route::post('/logout','logout');
});

Route::get('/', function(){
    return "test route";
});





// Route::middleware('auth:sanctum')->group(function () {

// });
