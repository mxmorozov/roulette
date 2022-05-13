<?php

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->post('/api/roll', function (Request $request) {
    $game = $request->user()->currentGame();
    $cell = $game->roll();
    return response()->json($cell->value);
})->name('roll');


Route::get('/api/users-per-rolls', function (Request $request) {
    return response()->json(ReportService::usersPerRolls());
})->name('users-per-rolls');

Route::get('/api/active-users', function (Request $request) {
    return response()->json(ReportService::activeUsers());
})->name('active-users');
