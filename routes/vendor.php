<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Vendor\PagesController;
use App\Http\Controllers\API\Vendor\FaqController;

### ### Protected Routes ### ###
Route::group(['middleware' => ['auth:vendor-api', 'scopes:vendor']], function () {

    // Pages
    Route::apiResource('pages', PagesController::class , ['as' => 'vendor.pages'])->except('store', 'destroy');

    //Faqs
    Route::apiResource('faqs', FaqController::class , ['as' => 'vendor.faqs']);
    
});
### ### Protected Routes ### ###
