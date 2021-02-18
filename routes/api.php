<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Me\SnippetController as MeSnippetController;
use App\Http\Controllers\Snippets\SnippetController;
use App\Http\Controllers\Snippets\StepController;
use App\Http\Controllers\Users\UserController;
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
Route::prefix('auth')->group(function() {
    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/register', [RegisterController::class, '__invoke']);
    Route::get('/me', [MeController::class, '__invoke']);
    Route::post('/logout', [LogoutController::class, '__invoke']);
});

Route::prefix('snippets')->namespace('Snippets')->group(function() {
    Route::get('', [SnippetController::class, 'index']);
    Route::post('', [SnippetController::class, 'store']);
    Route::get('/{snippet}', [SnippetController::class, 'show']);
    Route::patch('/{snippet}', [SnippetController::class, 'update']);
    Route::delete('/{snippet}', [SnippetController::class, 'destroy']);
    
    Route::patch('{snippet}/steps/{step}', [StepController::class, 'update']);
    Route::delete('{snippet}/steps/{step}', [StepController::class, 'destroy']);
    Route::post('{snippet}/steps', [StepController::class, 'store']);
});

Route::prefix('me')->group(function() {
    Route::get('/snippets', [App\Http\Controllers\Me\SnippetController::class, 'index']);
});

Route::prefix('keys')->group(function() {
    Route::get('/algolia', [App\Http\Controllers\Keys\AlgoliaKeyController::class, '__invoke']);
});
Route::prefix('users/{user}')->group(function() {
    Route::get('', [UserController::class, 'show']);
    Route::patch('', [UserController::class, 'update']);
    Route::get('/snippets', [App\Http\Controllers\Users\SnippetController::class, 'index']);
});