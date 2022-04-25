<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageLocationController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');
// Auth::routes();
// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

    Route::group(['middleware' => 'role:admin'], function () {

        Route::get('admin_dashboard', [\App\Http\Controllers\Admin\DashboardControlle::class, 'index']);

        // Type
        Route::get('type', [TypeController::class, 'index'])->name('type');
        Route::post('type/add', [TypeController::class, 'store'])->name('addType');
        Route::get('type/edit/{id}', [TypeController::class, 'edit']);
        Route::post('type/update/{id}', [TypeController::class, 'update']);
        Route::get('type/delete/{id}', [TypeController::class, 'delete']);

        // Stock
        Route::get('stock', [StockController::class, 'index'])->name('stock');
        Route::post('stock/add', [StockController::class, 'store'])->name('addStock');

        Route::get('stock/add_stock', [StockController::class, 'add'])->name('add_stock');
        Route::get('stock/edit/{id}', [StockController::class, 'edit']);
        Route::post('stock/update/{id}', [StockController::class, 'update']);
        Route::get('stock/delete/{id}', [StockController::class, 'delete']);

        // Device
        Route::get('device', [DeviceController::class, 'index'])->name('device');
        Route::post('device', [DeviceController::class, 'store'])->name('addDevice');

        Route::get('device/add_device', [DeviceController::class, 'add'])->name('add_device');
    });

    Route::group(['middleware' => 'role:personnel'], function () {
        Route::get('personnel_dashboard', [\App\Http\Controllers\Personnel\DashboardController::class, 'index'])->name('personnel_dashboard');
        Route::get('personnel_borrow', [\App\Http\Controllers\Personnel\BorrowController::class, 'index'])->name('personnel_borrow');
    });
    Route::group(['middleware' => 'role:student'], function () {
        Route::get('student_dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student_dashboard');
        Route::get('student_borrow', [\App\Http\Controllers\Student\BorrowController::class, 'index'])->name('student_borrow');
        Route::get('student_borrow/select/{id}', [\App\Http\Controllers\Student\BorrowController::class, 'filters'])->name('student_borrow_select');
    });

    // Search
    Route::get('people', [SearchController::class, 'index'])->name('search');
    Route::get('people/simple', [SearchController::class, 'simple'])->name('simple_search');
    Route::get('people/advance', [SearchController::class, 'advance'])->name('advance_search');
});


