<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mortezaa97\Catalogs\Http\Controllers\Cataglog\FilterCatalogController;
use Mortezaa97\Catalogs\Http\Controllers\Cataglog\OptionsCatalogController;

Route::prefix('api')->middleware('api')->group(callback: function () {
    Route::get('catalogs/options/{catalog:slug}', OptionsCatalogController::class)->name('catalog.options');
    Route::post('catalogs/filter/{catalog:slug}', FilterCatalogController::class)->name('catalog.filter');
    
});
