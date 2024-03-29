<?php

use App\Http\Controllers\Fortnite\{FortniteController,
    FortniteCreativeController,
    FortniteEventController,
    FortniteNewsController,
    FortniteShopController};
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

Route::get('/', [FortniteController::class, 'index']);

Route::prefix('/player')->group(function () {
    Route::get('/{username}', [FortniteController::class, 'player'])->name('fn-player');

    Route::post('/search', [FortniteController::class, 'search']);
    Route::post('/update', [FortniteController::class, 'update']);
});

Route::prefix('/shop')->group(function () {
    Route::get('/', [FortniteShopController::class, 'index']);
    Route::get('/cosmetic/{cosmeticID}', [FortniteShopController::class, 'cosmetic']);

    Route::post('/cosmetic/update', [FortniteShopController::class, 'update']);
});

Route::get('/events', [FortniteEventController::class, 'index']);

Route::get('/news', [FortniteNewsController::class, 'news']);

Route::prefix('/creative')->group(function () {
    Route::get('/', [FortniteCreativeController::class, 'index']);
    Route::get('/island/{code}', [FortniteCreativeController::class, 'island'])->name('ct-island');

    Route::post('/search', [FortniteCreativeController::class, 'search']);
    Route::post('/update', [FortniteCreativeController::class, 'update']);
    Route::post('/update/feature/islands', [FortniteCreativeController::class, 'updateFeaturedIslands']);
});

