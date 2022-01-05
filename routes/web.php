<?php

use App\Http\Controllers\Fortnite\FortniteController;
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

Route::get('/creative', function () {
    return Inertia::render('Creative/Index');
});

Route::get('/events', function () {
    return Inertia::render('Events/Index');
});

Route::get('/news', function () {
    return Inertia::render('News/Index');
});

Route::get('/shop', function () {
    return Inertia::render('Shop/Index');
});

Route::prefix('/player')->group(function () {
    Route::get('/{username}', [FortniteController::class, 'player'])->name('fn-player');

    Route::post('/search', [FortniteController::class, 'search']);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
