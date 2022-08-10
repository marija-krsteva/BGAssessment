<?php

use App\Http\Controllers\API\ExchangeController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\MainController;
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

Route::controller(MainController::class)->group(function () {
    Route::get('/exchange', 'exchange');
});

Route::apiResources([
    'items'=> ItemController::class,
    'exchanges' => ExchangeController::class
]);
