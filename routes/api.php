<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExampleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerseController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\GalleryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::get('/example', [ExampleController::class, 'example']);

// Auth routes (public)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Verse routes (public)
Route::prefix('verses')->group(function () {
    Route::get('/', [VerseController::class, 'index']);
    Route::get('/today', [VerseController::class, 'today']);
    Route::get('/{id}', [VerseController::class, 'show']);
});

// Events routes (public)
Route::prefix('events')->group(function () {
    Route::get('/birthdays/today', [EventsController::class, 'birthdaysToday']);
    Route::get('/birthdays/upcoming', [EventsController::class, 'birthdaysUpcoming']);
    Route::get('/birthdays', [EventsController::class, 'allBirthdays']);
    Route::get('/anniversaries/today', [EventsController::class, 'anniversariesToday']);
    Route::get('/anniversaries/upcoming', [EventsController::class, 'anniversariesUpcoming']);
    Route::get('/anniversaries', [EventsController::class, 'allAnniversaries']);
});

// Gallery routes (public)
Route::prefix('gallery')->group(function () {
    Route::get('/folders', [GalleryController::class, 'folders']);
    Route::get('/images', [GalleryController::class, 'images']);
    Route::get('/folder/{folder_id}', [GalleryController::class, 'folderImages']);
});

// Protected routes (require JWT token)
Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

