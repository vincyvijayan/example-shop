<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\StoreController;

use App\Http\Controllers\OnlinestoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Register and login*/
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
/*Register and login*/


/*E-commerce manger*/
Route::get('ecommerce-manager', [StoreController::class, 'index'])->name('ecommerce-manager');
Route::get('onlinestore', [StoreController::class, 'onlinestore'])->name('onlinestore');
Route::get('create-product', [StoreController::class, 'create'])->name('onlinestore.create-product');
Route::get('create-category', [StoreController::class, 'create_category'])->name('onlinestore.create-category');
Route::post('store-category', [StoreController::class, 'storeCategory'])->name('onlinestore.storecategory');
Route::post('store', [StoreController::class, 'store'])->name('onlinestore.store');
Route::get('onlinestore-edit/{id}', [StoreController::class, 'edit'])->name('onlinestore-edit');
Route::put('onlinestore-update/{id}', [StoreController::class, 'update'])->name('onlinestore-update');
Route::delete('onlinestore-destroy/{id}', [StoreController::class, 'destroy'])->name('onlinestore-destroy');

/*E-commerce manger*/

/*onlinestore*/

Route::get('products', [OnlinestoreController::class, 'index'])->name('products');
Route::get('cart', [OnlinestoreController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [OnlinestoreController::class, 'addToCart'])->name('add-to-cart');
Route::put('update-cart', [OnlinestoreController::class, 'update'])->name('update-cart');
Route::delete('remove-cart', [OnlinestoreController::class, 'remove'])->name('remove-cart');


Route::get('checkout', [OnlinestoreController::class, 'checkout'])->name('checkout');
Route::post('place-order', [OnlinestoreController::class, 'placeOrder'])->name('place-order');
Route::get('apply_voucher/{voucher_code}', [OnlinestoreController::class, 'apply_voucher'])->name('apply_voucher');



/*onlinestore*/
