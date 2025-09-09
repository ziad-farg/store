<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;


Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function () {

    // dashboard home
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // trashed categories
    Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    // restore categories from trash
    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    // archive categories
    Route::put('categories/{category}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
    // force delete categories in the trash
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    // trashed products
    Route::get('products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
    // restore products from trash
    Route::put('products/{category}/restore', [ProductController::class, 'restore'])->name('products.restore');
    // archive products
    Route::put('products/{category}/delete', [ProductController::class, 'delete'])->name('products.delete');
    // force delete products in the trash
    Route::delete('products/{category}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    Route::resources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
    ]);
});
