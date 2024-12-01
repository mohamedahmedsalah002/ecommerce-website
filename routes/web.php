<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Middleware\CheckNotAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\IsAdmin;



// after first login delete session
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::get('/register', 'register')->name('register');
        // i feel logout should be post request
        Route::get('/logout', 'logout')->name('logout')->withoutMiddleware('guest');
        Route::post('/handleLogin', 'handleLogin')->name('handleLogin');
        Route::post('/handleRegister', 'handleRegister')->name('handleRegister');
    });
});


/// Admin routes/////
Route::middleware(['auth', IsAdmin::class])->prefix('/admin')->name('admin.')->group(function () {
    // Product routes
    Route::controller(ProductController::class)->name('product.')->group(function () {
        Route::get('/product', 'index')->name('index');
        Route::get('/product/add', 'add')->name('add');
        Route::post('/product/store', 'store')->name('store');
        Route::get('/product/{id}', 'show')->name('show');
        Route::get('/product/edit/{id}', 'edit')->name('edit');
        Route::put('/product/update/{id}', 'update')->name('update'); // Route for updating a product
        Route::delete('/product/destroy/{id}', 'destroy')->name('destroy'); // Route for deleting a product
    });
    // Category routes
    Route::controller( CategoryController::class)->name('category.')->group(function () {
    
        Route::get('/category/create', 'create')->name('create'); // Form to create a new category
        Route::post('/category/store', 'store')->name('store'); // Store the new category
    });
});






////// welcome route /////
Route::middleware([CheckNotAdmin::class])->controller(WelcomeController::class)->group(function() {
    Route::get('/','welcome')->name('welcome');
});

Route::get('/product/item/{id}', [ProductsController::class, 'show'])->name('productShow');







    //////cart routes///////

    Route::controller(CartController::class)->name('cart.')->group(function(){
        Route::post('/cart/add/{id}', 'addItemtoCart')->name('addCart');
        Route::get('/cart', 'getCartItems')->name('view');

        Route::prefix('/item')->name('item.')->group(function(){
            Route::post('/add/{id}', 'addItem')->name('add');
            Route::post('/remove/{id}', 'removeItem')->name('remove');
            Route::delete('/delete/{id}', 'deleteItem')->name('delete');


        });
    });


    /////// order routes//////  





    Route::middleware('auth')->prefix('customer/orders')->name('customer.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');           // List orders
        Route::get('create', [OrderController::class, 'create'])->name('create');    // Show create order form
        Route::post('/', [OrderController::class, 'store'])->name('store');          // Store a new order
        Route::get('{id}', [OrderController::class, 'show'])->name('show');          // Show a single order
        Route::delete('{id}', [OrderController::class, 'destroy'])->name('destroy'); // Delete an order
    });
    