<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\Vendor\FaqController;
use App\Http\Controllers\API\User\AddressController;
use App\Http\Controllers\API\Vendor\PagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => '{name}', 'middleware' => ['identify.shop']], function () {

    // Pages
    Route::get('page/{slug}', [PagesController::class, 'getPageBySlug']);

    // Faqs
    Route::get('faqs', [FaqController::class, 'index']);

    Route::group(['middleware' => ['auth:user-api', 'scopes:user']], function () {

        // Addresses
        Route::apiResource('addresses', AddressController::class, ['as' => 'user.addresses'])->except(['update', 'show']);

    });
});
