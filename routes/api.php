<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/sites', [App\Http\Controllers\ProductsController::class, 'getSites']);
Route::get('/services/{product_category}/{site?}', [App\Http\Controllers\ProductsController::class, 'getServices']);
Route::get('/services/{product_category}', [App\Http\Controllers\ProductsController::class, 'getServices']);
Route::get('/services/{slug}/{type}/{is_siae}/products', [App\Http\Controllers\ProductsController::class, 'getProducts']);
Route::get('/evento/{eventoId}/ordineposto/{cod_ordine_posto}/disponibilita', [App\Http\Controllers\ProductsController::class, 'getDisponibilitaOrdinePosto']);

// biglietteria online - carrello
Route::get('/cart_products/cart', [App\Http\Controllers\CartProductController::class, 'index']);
Route::post('/cart_products/store', [App\Http\Controllers\CartProductController::class, 'store']);
Route::post('/cart_products/{cartProductId}/destroy', [App\Http\Controllers\CartProductController::class, 'destroy']);
Route::post('/cart_products/destroy-many', [App\Http\Controllers\CartProductController::class, 'destroyMany']);

// biglietteria online - ordine
Route::post('/orders/store', [App\Http\Controllers\OrderController::class, 'store']);
Route::get('/orders/history', [App\Http\Controllers\OrderController::class, 'history'])->name('orders.history');
Route::get('/orders/{id}/tickets', [App\Http\Controllers\OrderController::class, 'tickets'])->name('orders.tickets');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
