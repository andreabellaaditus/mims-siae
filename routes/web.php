<?php
use App\Filament\Resources\OrderResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
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


Route::get('/siae', function () {
    return view('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/onsite/tickets/print/{order_id}', ['as' => '/onsite/tickets/print/order', 'uses' => 'App\Services\OrderService@layout_onsite_ticket']);
Route::get('/import_db', ['as' => '/import_db', 'uses' => 'App\Services\ImportService@import_old_db']);

Route::any('/test-tornelli', 'App\Http\Controllers\AccessControlController@validateTicket');

Route::post('/endpayment', [OrderController::class, 'endpayment']);
Route::get('/admin/orders/export', [OrderResource::class, 'export']);

Route::get('/auth/unauthorized', [App\Http\Controllers\AuthController::class, 'unauthorized']);
Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);

// cronjob geteventi siae
Route::get('/run-fetch-events', function () {
    Artisan::call('job:fetch-events');
    return 'Eventi importati';
});
