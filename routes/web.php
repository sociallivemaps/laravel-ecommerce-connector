<?php

use Illuminate\Support\Facades\Route;
use Solimap\Ecommerce\Http\Controllers\ProductController;
use Solimap\Ecommerce\Http\Controllers\BundleController;

Route::group([
    'prefix' => config('solimap.app.prefix', 'solimap'),
    'as' => 'solimap.',
    'middleware' => ['web'],
], function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/filter', [ProductController::class, 'filter']);
    Route::get('/products/search', [ProductController::class, 'search']);

    Route::get('/bundles',  [BundleController::class, 'index'])->name('bundles.index');
    Route::get('/bundles/search', [BundleController::class, 'search']);
    Route::get('/vendor/{id}', [ProductController::class, 'show_vendor'])->name('products.vendor');
});
