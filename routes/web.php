<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name(
        'auth#loginPage'
    );
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name(
        'auth#registerPage'
    );
});

Route::middleware([
    'auth',
    // 'auth:sanctum',
    // config('jetstream.auth_session'),
    // 'verified',
])->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name(
        'dashboard'
    );

    Route::middleware(['admin_auth'])->group(function () {
        // Category
        Route::group(['prefix' => 'category'], function () {
            Route::get('list', [CategoryController::class, 'list'])->name(
                'category#list'
            );

            Route::get('create', [
                CategoryController::class,
                'createPage',
            ])->name('category#createPage');

            Route::post('create', [CategoryController::class, 'store'])->name(
                'category#create'
            );

            Route::get('delete/{id}', [
                CategoryController::class,
                'delete',
            ])->name('category#delete');

            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name(
                'category#edit'
            );

            Route::post('update/{id}', [
                CategoryController::class,
                'update',
            ])->name('category#update');
        });
        // Admin Password
        Route::prefix('admin')->group(function () {
            // Password
            Route::get('password/changePage', [
                AdminController::class,
                'changePasswordPage',
            ])->name('admin#changePasswordPage');

            Route::post('password/change', [
                AdminController::class,
                'updatePassword',
            ])->name('admin#updatePassword');

            // Account
            Route::get('account/details', [
                AdminController::class,
                'accountDetails',
            ])->name('admin#accountDetails');

            Route::get('account/edit', [
                AdminController::class,
                'accountEdit',
            ])->name('admin#accountEdit');

            Route::post('account/update/{id}', [
                AdminController::class,
                'accountUpdate',
            ])->name('admin#accountUpdate');

            // Account List
            Route::get('list', [AdminController::class, 'list'])->name(
                'admin#accountList'
            );

            // Delete account
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name(
                'admin#accountDelete'
            );
        });

        // Product
        Route::prefix('product')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name(
                'product#list'
            );

            Route::get('create', [ProductController::class, 'create'])->name(
                'product#createPage'
            );

            Route::post('store', [ProductController::class, 'store'])->name(
                'product#store'
            );

            Route::get('show/{id}', [ProductController::class, 'show'])->name(
                'product#show'
            );

            Route::get('edit/{id}', [ProductController::class, 'edit'])->name(
                'product#edit'
            );

            Route::post('update/{id}', [
                ProductController::class,
                'update',
            ])->name('product#update');
            Route::get('delete/{id}', [
                ProductController::class,
                'delete',
            ])->name('product#delete');
        });
    });

    Route::group(
        ['prefix' => 'user', 'middleware' => 'user_auth'],
        function () {
            Route::get('home', [UserController::class, 'homePage'])->name(
                'user#home'
            );

            Route::get('filter/{id}', [UserController::class, 'filter'])->name(
                'user#filter'
            );

            // USER ACCOUNTS OPERATIONS
            Route::get('password/change', [
                UserController::class,
                'changePasswordPage',
            ])->name('user#changePasswordPage');

            Route::post('password/change', [
                UserController::class,
                'updatePassword',
            ])->name('user#updatePassword');

            Route::get('account/edit', [
                UserController::class,
                'accountEditPage',
            ])->name('user#accountEdit');

            Route::post('account/update/{id}', [
                UserController::class,
                'updateAccount',
            ])->name('user#accountUpdate');

            Route::prefix('ajax')->group(function () {
                Route::get('product/list', [
                    AjaxController::class,
                    'productList',
                ])->name('ajax#productList');
            });



            Route::get('product/details/{id}', [
                UserController::class,
                'productDetails',
            ])->name('user#productDetails');
        }
    );
});
