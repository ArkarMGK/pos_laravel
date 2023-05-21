<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserAjaxController;
use App\Http\Controllers\User\UserProductController;

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
        // Admin Password
        Route::prefix('admin')->group(function () {
            // Password
            Route::group(['prefix' => 'category'], function () {
                Route::get('list', [CategoryController::class, 'list'])->name(
                    'category#list'
                );
                Route::get('create', [
                    CategoryController::class,
                    'createPage',
                ])->name('category#createPage');

                Route::post('create', [
                    CategoryController::class,
                    'store',
                ])->name('category#create');

                Route::get('delete/{id}', [
                    CategoryController::class,
                    'delete',
                ])->name('category#delete');

                Route::get('edit/{id}', [
                    CategoryController::class,
                    'edit',
                ])->name('category#edit');

                Route::post('update/{id}', [
                    CategoryController::class,
                    'update',
                ])->name('category#update');
            });

            // Account
            Route::prefix('account')->group(function () {
                Route::get('password/changePage', [
                    AdminController::class,
                    'changePasswordPage',
                ])->name('admin#changePasswordPage');

                Route::post('password/change', [
                    AdminController::class,
                    'updatePassword',
                ])->name('admin#updatePassword');

                Route::get('details', [
                    AdminController::class,
                    'accountDetails',
                ])->name('admin#accountDetails');

                Route::get('edit', [
                    AdminController::class,
                    'accountEdit',
                ])->name('admin#accountEdit');

                Route::post('update/{id}', [
                    AdminController::class,
                    'accountUpdate',
                ])->name('admin#accountUpdate');

                // Account List
                Route::get('list', [AdminController::class, 'list'])->name(
                    'admin#accountList'
                );

                // Delete account
                Route::get('delete/{id}', [
                    AdminController::class,
                    'delete',
                ])->name('admin#accountDelete');
            });

            // Product
            Route::prefix('product')->group(function () {
                Route::get('list', [ProductController::class, 'list'])->name(
                    'product#list'
                );

                Route::get('create', [
                    ProductController::class,
                    'create',
                ])->name('product#createPage');

                Route::post('store', [ProductController::class, 'store'])->name(
                    'product#store'
                );

                Route::get('show/{id}', [
                    ProductController::class,
                    'show',
                ])->name('product#show');

                Route::get('edit/{id}', [
                    ProductController::class,
                    'edit',
                ])->name('product#edit');

                Route::post('update/{id}', [
                    ProductController::class,
                    'update',
                ])->name('product#update');
                Route::get('delete/{id}', [
                    ProductController::class,
                    'delete',
                ])->name('product#delete');
            });

            Route::prefix('order')->group(function () {
                Route::get('list', [OrderController::class, 'orderList'])->name(
                    'order#list'
                );
                Route::get('status', [
                    OrderController::class,
                    'viewByOrderStatus',
                ])->name('order#status');

                Route::get('orderCode/{code}', [
                    OrderController::class,
                    'showOrderDetails',
                ])->name('order#orderCode');
            });

            Route::prefix('customer')->group(function () {
                Route::get('list', [CustomerController::class, 'list'])->name(
                    'customer#list'
                );
            });
            // Ajax
            Route::prefix('ajax')->group(function () {
                // Route::get('order/status', [
                //     AjaxController::class,
                //     'viewOrderByStatus',
                // ]);

                Route::get('order/status/change', [
                    AjaxController::class,
                    'changeOrderStatus',
                ]);

                Route::get('user/role/change', [
                    AjaxController::class,
                    'changeUserRole',
                ]);
            });
        });
    });

    // USER SITE
    Route::group(
        ['prefix' => 'user', 'middleware' => 'user_auth'],
        function () {
            Route::get('home', [UserController::class, 'homePage'])->name(
                'user#home'
            );

            Route::get('filter/{id}', [UserController::class, 'filter'])->name(
                'user#filter'
            );

            Route::get('history', [UserController::class, 'history'])->name(
                'user#history'
            );

            Route::get('contact/us', [
                UserController::class,
                'contactUs',
            ])->name('user#contactUs');

            Route::post('contact/messaage', [
                UserController::class,
                'saveContactMessage',
            ])->name('user#contactUsMessage');

            // USER ACCOUNTS OPERATIONS
            Route::get('change', [
                UserController::class,
                'changePasswordPage',
            ])->name('user#changePasswordPage');

            Route::post('change', [
                UserController::class,
                'updatePassword',
            ])->name('user#updatePassword');

            Route::get('edit', [
                UserController::class,
                'accountEditPage',
            ])->name('user#accountEdit');

            Route::post('update/{id}', [
                UserController::class,
                'updateAccount',
            ])->name('user#accountUpdate');

            Route::prefix('product')->group(function () {
                Route::get('details/{id}', [
                    UserProductController::class,
                    'productDetails',
                ])->name('user#productDetails');

                Route::get('cart', [
                    UserProductController::class,
                    'cartList',
                ])->name('user#cart');
            });

            Route::prefix('ajax')->group(function () {
                Route::get('product/list', [
                    UserAjaxController::class,
                    'productList',
                ])->name('user#ajax#productList');

                Route::get('product/increase/viewCount', [
                    UserAjaxController::class,
                    'increaseProductViewCount',
                ]);

                Route::get('addToCart', [
                    UserAjaxController::class,
                    'addToCart',
                ])->name('user#ajax#addToCart');

                Route::get('order', [
                    UserAjaxController::class,
                    'addOrder',
                ])->name('user#ajax#order');

                Route::get('clear/cart', [
                    UserAjaxController::class,
                    'clearCart',
                ])->name('user#ajax#clearCart');
            });
        }
    );
});
