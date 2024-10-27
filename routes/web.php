<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// routes/web.php

Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');


// routes/web.php


Route::get('/products', [ProductController::class, 'index'])->name('products.index');


// routes/web.php


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');


// routes/web.php


Route::get('/carts', [CartController::class, 'index'])->name('carts.index');


// routes/web.php


Route::get('/cart_items', [CartItemController::class, 'index'])->name('cart_items.index');




Route::get('/categories', [CartItemController::class, 'index'])->name('categories.index');





Route::get('/orders', [CartItemController::class, 'index'])->name('orders.index');





Route::get('/orders_items', [CartItemController::class, 'index'])->name('orders_items.index');




Route::get('/payments', [CartItemController::class, 'index'])->name('payments.index');



Route::get('/paymentsmethods', [CartItemController::class, 'index'])->name('paymentsmethods.index');


Route::get('/customers/create', function () {
    return view('customers'); // هنا يجب أن يكون اسم العرض مطابقًا لاسم ملف الـ Blade
})->name('customers.create');

// إرسال البيانات لتخزين الزبون الجديد
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');