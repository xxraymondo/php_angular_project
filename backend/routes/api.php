<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);


//routes for the ProductController
// Allow unauthenticated access to list products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/images/products/{imageName}', 'ProductController@getImage');

Route::get('/products/{productId}', [ProductController::class, 'getProductById']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Routes that require admin role
    Route::any('/admin-panel' , [UserController::class, 'adminPanel']);
    Route::get('/users', [UserController::class, 'listUsers']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::get('/orders', [OrderController::class, 'viewAllOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'getOrderById']);
    Route::put('/orders/{id}/update-status', [OrderController::class, 'updateOrderStatus']);
});


 //  cart Routes
 Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart']);
   // View the cart items
Route::get('/view-cart-items', [CartController::class, 'viewCartItems']);
Route::delete('/remove-cart-item/{cartItemId}', [CartController::class, 'removeCartItem']);

Route::post('/cart/increase/{cartItemId}', [CartController::class, 'increaseProductQuantity']);
Route::post('/cart/decrease/{cartItemId}', [CartController::class, 'decreaseProductQuantity']);
Route::delete('/cart/empty', [CartController::class, 'emptyCart']);

 });

 //order apis
 Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/place-order', [OrderController::class, 'createOrder']);
    Route::get('/my-orders', [OrderController::class, 'myListOrders']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
