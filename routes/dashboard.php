<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;


Route::middleware('auth')->as('dashboard.')->prefix('dashboard')->group(function () {

    // dashboard home
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // trashed categories
    Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    // restore categories from trash
    Route::put('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    // archive categories
    Route::put('categories/{category}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
    // force delete categories in the trash
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    // trashed products
    Route::get('products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
    // restore products from trash
    Route::put('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
    // archive products
    Route::put('products/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');
    // force delete products in the trash
    Route::delete('products/{product}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    // profile routes
    // Profile routes operate on the authenticated user's profile (no id required).
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
    ]);
});
