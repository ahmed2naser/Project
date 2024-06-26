<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function(){

    Route::get('/', function (){
        return view('auth.login');
    });
    Route::get('/dashboard', function () {
        return view('backend.dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::get('/admin_dashboard', function () {
        return view('backend.admin_dashboard');
    })->middleware(['auth:admin'])->name('admin_dashboard');

    // categories
    Route::resource('categories',CategorieController::class);

    // products
    Route::resource('products', ProductController::class);

    // invoices
    Route::get('/product/{id}', [InvoiceController::class, 'getProduct']);
    Route::get('/price/{id}', [InvoiceController::class, 'getPrice']);
    Route::post('Payment_status', [InvoiceController::class, 'payment_statusChange'])->name('Payment_status_change');
    Route::resource('invoices', InvoiceController::class);

    require __DIR__.'/auth.php';

});




