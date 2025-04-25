<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;

Route::get('/admin/select', [AdminController::class, 'showSelectAdminForm'])->name('admin.select.form');
Route::post('/admin/select', [AdminController::class, 'selectAdmin'])->name('admin.select');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::match(['get', 'post'], '/items', [ItemController::class, 'index'])->name('items.index');
Route::match(['get', 'post'], '/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::match(['get', 'post'], '/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');