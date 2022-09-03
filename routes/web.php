<?php

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
    return view('welcome');
});
Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function() {

    Route::get("/contacts_card/", [\App\Http\Controllers\ContactController::class, 'index']);

});
