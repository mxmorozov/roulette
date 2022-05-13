<?php

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::guest()) {
        UserService::newUser();
    }
    return view('welcome', ['state' => [
        'user' => Auth::user(),
        'lastRoll' => Auth::user()->currentGame()->lastRoll()?->cell->value,
    ]]);
});

Route::post('/change-user', function () {
    UserService::newUser();
    return response()->redirectTo('/');
})->name('change-user');
