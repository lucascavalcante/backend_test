<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function() {
    return response()->json([
        'message' => 'Welcome to Casafy'
    ], 200);
});

Route::resource('users', UserController::class);
Route::resource('properties', PropertyController::class);

Route::get('users/{id}/properties', [UserController::class, 'getProperties'])->name('users.properties');
Route::patch('properties/{id}/purchased/{value}', [PropertyController::class, 'setPurchased'])->name('properties.purchased');

Route::fallback(function() {
    return response()->json([
        'message' => 'Endpoint not found'
    ], 404);
});