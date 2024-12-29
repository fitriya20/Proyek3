<?php

use App\Http\Controllers\WEB\Admin\AdminController;
use App\Http\Controllers\WEB\Auth\LoginController;
use App\Http\Controllers\WEB\Auth\RegisterController;
use App\Http\Controllers\WEB\Customer\CustomerController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerController::class, 'index'])->name('customer');
Route::get('paket', [CustomerController::class, 'paket'])->name('customer.paket');
Route::get('contact', [CustomerController::class, 'contact'])->name('customer.contact');
Route::get('about', [CustomerController::class, 'about'])->name('customer.about');
Route::get('map', [CustomerController::class, 'map'])->name('customer.map');

Route::prefix('login/')->group(function () {
    Route::get('index', [LoginController::class, 'index'])->name('login');
    Route::post('create', [LoginController::class, 'create'])->name('login.create');
});

Route::prefix('register/')->group(function () {
    Route::get('index', [RegisterController::class, 'index'])->name('register');
    Route::post('create', [RegisterController::class, 'create'])->name('register.create');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['role:' . Role::ADMIN])->prefix('admin/')->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('data-customer', [AdminController::class, 'customer'])->name('admin.customer');
        Route::post('data-customer/store', [AdminController::class, 'customerStore'])->name('admin.customer.store');
        Route::delete('data-customer/{user}/delete', [AdminController::class, 'customerDeleted'])->name('admin.customer.delete');
        Route::put('data-customer/{user}/update', [AdminController::class, 'customerUpdate'])->name('admin.customer.update');
        Route::get('data-customer-order', [AdminController::class, 'customer_order'])->name('admin.customer-order');
        Route::put('data-customer-order/{id}', [AdminController::class, 'customer_order_update'])->name('admin.customer-order-update');
        Route::get('data-profit', [AdminController::class, 'profit'])->name('admin.profit');
        Route::get('data-product', [AdminController::class, 'product'])->name('admin.product');
        Route::post('data-product/store', [AdminController::class, 'store'])->name('admin.product.store');
        Route::put('data-product/{product}/edit', [AdminController::class, 'edit'])->name('admin.product.edit');
        Route::delete('data-product/{product}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');
        Route::get('data-category', [AdminController::class, 'category'])->name('admin.category');
        Route::post('data-category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
        Route::delete('data-category/{product}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

        Route::get('driver', [AdminController::class, 'driver'])->name('admin.driver');
        Route::post('driver/store', [AdminController::class, 'driver_store'])->name('admin.driver.store');
        Route::put('driver/{driver}/edit', [AdminController::class, 'driver_edit'])->name('admin.driver.edit');
        Route::delete('driver/{driver}/delete', [AdminController::class, 'driver_delete'])->name('admin.driver.delete');

        Route::get('export-profit', [AdminController::class, 'exportProfit'])->name('admin.export');
        
        
    });

    Route::middleware(['role:' . Role::CUSTOMER])->group(function () {
        Route::get('home', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/pesan/{name}', [CustomerController::class, 'pesan'])->name('customer.pesan');
        Route::post('/pesan/{name}/proses', [CustomerController::class, 'proses'])->name('customer.proses');
        Route::get('/profil', [CustomerController::class, 'profil'])->name('customer.profil');
        Route::put('/profil/edit', [CustomerController::class, 'profil_edit'])->name('customer.profil.edit');
    });
});
