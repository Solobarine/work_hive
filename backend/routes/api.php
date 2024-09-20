<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

//Route::get('/user', function (Request $request) {
//  return $request->user();
//})->middleware('auth:sanctum');

Route::get('failed', function () {
    return response()->json([
        "error" => 'Unauthorized'
    ], 401);
})->name("login");

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:api');
    Route::get('/user', 'user')->middleware("auth:api");
});

Route::controller(TaskController::class)->middleware("auth:api")->group(function () {
    Route::get('/tasks', 'index');
    Route::post('/tasks', 'store');
    Route::get('/tasks/{task}', 'show');
    Route::patch('/tasks/{task}', 'update');
    Route::delete('/tasks/{task}', 'destroy');
});
