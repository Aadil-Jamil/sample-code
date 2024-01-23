<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Vendor\FaqController;
use App\Http\Controllers\API\Vendor\PagesController;

### ### Authenticated Routes For Admin only ### ###
Route::group(['middleware' => ['auth:admin-api','scopes:admin','role:admin']], function () {
    
    //Pages
    Route::apiResource('vendor/pages', PagesController::class)->except('store', 'destroy');

    //Faqs
    Route::apiResource('vendor/faqs', FaqController::class);

});
### ### Authenticated Routes For Admin Only ### ###