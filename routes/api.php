<?php

use App\Http\Controllers\Fortnite\FortniteController;
use App\Http\Controllers\Fortnite\FortniteNewsController;
use App\Http\Controllers\Fortnite\FortniteShopController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/fortnite/news/br', [FortniteNewsController::class, 'index']);
Route::get('/fortnite/shop', [FortniteShopController::class, 'getCurrentShopWithAPI']);
