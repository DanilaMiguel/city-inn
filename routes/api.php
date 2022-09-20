<?php

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

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){

    Route::get('/index', [\App\Http\Controllers\PageController::class, 'index']);
    Route::get('/header/', [\App\Http\Controllers\PageController::class, 'header']);
    Route::get('/footer/', [\App\Http\Controllers\PageController::class, 'footer']);
    Route::get('/sitemap/', [\App\Http\Controllers\PageController::class, 'sitemap']);


    Route::get('/rooms/index', [\App\Http\Controllers\RoomController::class, 'index']);
    Route::get('/rooms/{code}', [\App\Http\Controllers\RoomController::class, 'show']);


    Route::get("/contacts/", [\App\Http\Controllers\ContactController::class, 'index']);

    Route::get('/restaurant-sviatoslav/', [\App\Http\Controllers\RestaurantController::class, 'index']);

    Route::get('/lobby-bar/', [\App\Http\Controllers\LobbyController::class, 'index']);

    Route::get('/about/', [\App\Http\Controllers\AboutController::class, 'index']);

    Route::get('/starfit/', [\App\Http\Controllers\StarFitController::class, 'index']);

    Route::get('/smart-offer/', [\App\Http\Controllers\SmartOfferController::class, 'index']);

    Route::get('/conference-service/index', [\App\Http\Controllers\ConferenceController::class, 'index']);
    Route::get('/conference-service/{code}', [\App\Http\Controllers\ConferenceController::class, 'show']);

    Route::get('/group-request/', [\App\Http\Controllers\GroupRequestController::class, 'index']);

    Route::get('/privacy-policy/',[\App\Http\Controllers\DocumentController::class, 'privacyPolicy']);
    Route::get('/public-offer/',[\App\Http\Controllers\DocumentController::class, 'publicOffer']);
});
