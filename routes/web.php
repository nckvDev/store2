<?php
use App\Http\Controllers\Admin\ManageRoleController;
use App\Http\Controllers\Admin\DataImportController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PrefixController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\DeviceImportController;
use App\Http\Controllers\Admin\StockImportController;
use App\Http\Controllers\Admin\DisposableImportController;
use App\Http\Controllers\ConfirmFormController;
use App\Http\Controllers\ConfirmUserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageLocationController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\Personnel\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DisposableController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\Personnel\BorrowController;
use App\Http\Controllers\Personnel\BorrowAllController;
use App\Http\Controllers\Personnel\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistersController;

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

//Auth::routes();
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegistersController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegistersController::class, 'registers']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

    // Admin
//    Route::get('admin_dashboard', [\App\Http\Controllers\Admin\DashboardControlle::class, 'index'])->middleware('role:admin');
//    Route::get('personnel_dashboard', [\App\Http\Controllers\Personnel\DashboardController::class, 'index'])->middleware('role:personnel');
//    Route::get('student_dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->middleware('role:student');

    // Manage User
    Route::get('UserManager', [ManageUserController::class, 'index'])->name('UserManager');

    // Manage Location
    Route::get('LocationManager', [ManageLocationController::class, 'index'])->name('LocationManager');

    Route::group(['middleware' => 'role:admin'], function () {

        Route::get('admin_dashboard', [\App\Http\Controllers\Admin\DashboardControlle::class, 'index'])->name('admin_dashboard');

        // Prefix
        Route::get('prefix', [\App\Http\Controllers\Admin\PrefixController::class, 'index'])->name('prefix');
        Route::post('prefix/add', [\App\Http\Controllers\Admin\PrefixController::class, 'store'])->name('addPrefix');
        Route::get('prefix/edit/{id}', [\App\Http\Controllers\Admin\PrefixController::class, 'edit']);
        Route::post('prefix/update/{id}', [\App\Http\Controllers\Admin\PrefixController::class, 'update']);
        Route::get('prefix/delete/{id}', [\App\Http\Controllers\Admin\PrefixController::class, 'delete']);

        // Manage Role
        Route::get('managerole', [\App\Http\Controllers\Admin\ManageRoleController::class, 'index'])->name('manage-role');
        Route::post('managerole/update/{id}', [\App\Http\Controllers\Admin\ManageRoleController::class, 'update']);
        Route::get('managerole/edit/{id}', [\App\Http\Controllers\Admin\ManageRoleController::class, 'edit']);
        Route::get('managerole/delete/{id}', [\App\Http\Controllers\Admin\ManageRoleController::class, 'delete']);

        // Department
        Route::get('department', [\App\Http\Controllers\Admin\DepartmentController::class, 'index'])->name('department');
        Route::post('department/add', [\App\Http\Controllers\Admin\DepartmentController::class, 'store'])->name('addDepartment');
        Route::get('department/edit/{id}', [\App\Http\Controllers\Admin\DepartmentController::class, 'edit']);
        Route::post('department/update/{id}', [\App\Http\Controllers\Admin\DepartmentController::class, 'update']);
        Route::get('department/delete/{id}', [\App\Http\Controllers\Admin\DepartmentController::class, 'delete']);

        // Group
        Route::get('group', [\App\Http\Controllers\Admin\GroupController::class, 'index'])->name('group');
        Route::post('group/add', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('addGroup');
        Route::get('group/edit/{id}', [\App\Http\Controllers\Admin\GroupController::class, 'edit']);
        Route::post('group/update/{id}', [\App\Http\Controllers\Admin\GroupController::class, 'update']);
        Route::get('group/delete/{id}', [\App\Http\Controllers\Admin\GroupController::class, 'delete']);

        // Import Data Excel&Csv
        Route::get('dataimport', [\App\Http\Controllers\Admin\DataImportController::class, 'index'])->name('data-import');
        Route::post('import', [\App\Http\Controllers\Admin\DataImportController::class, 'import'])->name('import-list');

        // Import Device Excel&Csv
        Route::get('device/import', [\App\Http\Controllers\Admin\DeviceImportController::class, 'index'])->name('device-import');
        Route::post('importdevice', [\App\Http\Controllers\Admin\DeviceImportController::class, 'import'])->name('import-device');

        // Import Stock Excel&Csv
        Route::get('stock/import', [\App\Http\Controllers\Admin\StockImportController::class, 'index'])->name('stock-import');
        Route::post('importstock', [\App\Http\Controllers\Admin\StockImportController::class, 'import'])->name('import-stock');

        // Import Disposable Excel&Csv
        Route::get('disposable/import', [\App\Http\Controllers\Admin\DisposableImportController::class, 'index'])->name('disposable-import');
        Route::post('importdisposable', [\App\Http\Controllers\Admin\DisposableImportController::class, 'import'])->name('import-disposable');


        // Form
        Route::get('confirmform', [ConfirmFormController::class, 'index'])->name('confirmform');
        Route::post('confirmform/update/{id}', [ConfirmFormController::class, 'update']);
        Route::post('confirmform/add', [ConfirmFormController::class, 'create'])->name('form-add');

        Route::get('confirmuser', [ConfirmUserController::class, 'index'])->name('form-detail');

        // Type
        Route::get('type', [TypeController::class, 'index'])->name('type');
        Route::post('type/add', [TypeController::class, 'store'])->name('addType');
        Route::get('type/edit/{id}', [TypeController::class, 'edit']);
        Route::post('type/update/{id}', [TypeController::class, 'update']);
        Route::get('type/delete/{id}', [TypeController::class, 'delete']);

        // Stock
        Route::get('stock', [StockController::class, 'index'])->name('stock');
        Route::post('stock/add', [StockController::class, 'store'])->name('addStock');
        
        Route::post('stock/fetch', [StockController::class, 'fetch'])->name('stock.fetch');
        Route::get('stock/add_stock', [StockController::class, 'add'])->name('add_stock');
        Route::get('stock/edit/{id}', [StockController::class, 'edit']); // show data edit
        Route::post('stock/update/{id}', [StockController::class, 'update']); // edit data
        Route::get('stock/delete/{id}', [StockController::class, 'delete']);

         // Disposable
         Route::get('disposable', [DisposableController::class, 'index'])->name('disposable');
         Route::post('disposable/add', [DisposableController::class, 'store'])->name('addDisposable');

         Route::post('disposable/fetch', [DisposableController::class, 'fetch'])->name('disposable.fetch');
         Route::get('disposable/add_disposable', [DisposableController::class, 'add'])->name('add_disposable');
         Route::get('disposable/edit/{id}', [DisposableController::class, 'edit']);
         Route::post('disposable/update/{id}', [DisposableController::class, 'update']);
         Route::get('disposable/delete/{id}', [DisposableController::class, 'delete']);

        // Device
        Route::get('device', [DeviceController::class, 'index'])->name('device');
        Route::post('device', [DeviceController::class, 'store'])->name('addDevice');

        Route::post('device/fetch', [DeviceController::class, 'fetch'])->name('device.fetch');
        Route::get('device/add_device', [DeviceController::class, 'add'])->name('add_device');
        Route::get('device/edit/{id}', [DeviceController::class, 'edit']); // show data edit
        Route::post('device/update/{id}', [DeviceController::class, 'update']); // edit data
        Route::get('device/delete/{id}', [DeviceController::class, 'delete']);

         // Export
         Route::get('/stock/export-xlsm', [\App\Http\Controllers\StockController::class,'exportXlsm'])->name('stock_report_xlsm');
         Route::get('/device/export-xlsm', [\App\Http\Controllers\DeviceController::class,'exportXlsm'])->name('device_report_xlsm');
         Route::get('/disposable/export-xlsm', [\App\Http\Controllers\DisposableController::class,'exportXlsm'])->name('disposable_report_xlsm');
    });

    Route::group(['middleware' => 'role:personnel'], function () {
        Route::get('personnel_dashboard', [DashboardController::class, 'index'])->name('personnel_dashboard');
        Route::post('personnel_dashboard/update/{id}', [DashboardController::class, 'update']);

        Route::get('personnel_borrow', [\App\Http\Controllers\Personnel\CartController::class, 'cartList'])->name('cart.list');
        Route::post('personnel_borrow/borrow', [\App\Http\Controllers\Personnel\CartController::class, 'addToCart'])->name('cart.store');
        Route::post('update-cart', [\App\Http\Controllers\Personnel\CartController::class, 'updateCart'])->name('cart.update');
        Route::post('remove', [\App\Http\Controllers\Personnel\CartController::class, 'removeCart'])->name('cart.remove');
        Route::post('clear', [\App\Http\Controllers\Personnel\CartController::class, 'clearAllCart'])->name('cart.clear');
        Route::post('save', [\App\Http\Controllers\Personnel\CartController::class, 'saveCart'])->name('cart.save');
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