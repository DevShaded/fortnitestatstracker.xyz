<?php

use App\Http\Controllers\Fortnite\FortniteController;
use App\Http\Controllers\Fortnite\FortniteCreativeController;
use App\Http\Controllers\Fortnite\FortniteShopController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::prefix('/creative')->group(function () {
    Route::get('/', [FortniteCreativeController::class, 'index']);
    Route::get('/island/{code}', [FortniteCreativeController::class, 'island'])->name('ct-island');

    Route::post('/search', [FortniteCreativeController::class, 'search']);
    Route::post('/update', [FortniteCreativeController::class, 'update']);
    Route::post('/update/feature/islands', [FortniteCreativeController::class, 'updateFeaturedIslands']);
});



Route::get('/events', function () {
    return Inertia::render('Events/Index');
});

Route::get('/news', function () {
    return Inertia::render('News/Index');
});

Route::prefix('/shop')->group(function () {
    Route::get('/', [FortniteShopController::class, 'index']);
});

Route::get('/shop', [FortniteShopController::class, 'index']);

Route::prefix('/player')->group(function () {
    Route::get('/{username}', [FortniteController::class, 'player'])->name('fn-player');

    Route::post('/search', [FortniteController::class, 'search']);
    Route::post('/update', [FortniteController::class, 'update']);
});


Route::get('login', function () {
    return redirect('/');
})->name('login');

Route::get('register', function () {
    return redirect('/');
})->name('register');
