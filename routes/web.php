<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

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
        });
    });

    Route::group(
        ['prefix' => 'user', 'middleware' => 'user_auth'],
        function () {
            Route::get('home', function () {
                return view('user.home');
            })->name('user#home');
        }
    );
});
