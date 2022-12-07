<?php
use App\Http\Controllers\Admin\ManageRoleController;
use App\Http\Controllers\Admin\DataImportController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PrefixController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\DeviceImportController;
use App\Http\Controllers\Admin\StockImportController;
use App\Http\Controllers\Admin\DisposableImportController;
use App\Http\Controllers\Admin\DashboardControlle;
use App\Http\Controllers\Admin\reportAllController;
use App\Http\Controllers\ConfirmFormController;
use App\Http\Controllers\ConfirmReturnController;
use App\Http\Controllers\ConfirmUserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageLocationController;
use App\Http\Controllers\ManageUserController;
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
//    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => 'role:admin'], function () {

        Route::get('admin_dashboard', [DashboardControlle::class, 'index'])->name('admin_dashboard');

        // Prefix
        Route::get('prefix', [PrefixController::class, 'index'])->name('prefix');
        Route::post('prefix/add', [PrefixController::class, 'store'])->name('addPrefix');
        Route::get('prefix/edit/{id}', [PrefixController::class, 'edit']);
        Route::post('prefix/update/{id}', [PrefixController::class, 'update']);
        Route::get('prefix/delete/{id}', [PrefixController::class, 'delete']);

        // Manage Role
        Route::get('manage-role', [ManageRoleController::class, 'index'])->name('manage-role');
        Route::post('manage-role/update/{id}', [ManageRoleController::class, 'update']);
        Route::get('manage-role/edit/{id}', [ManageRoleController::class, 'edit']);
        Route::get('manage-role/delete/{id}', [ManageRoleController::class, 'delete']);

        // Department
        Route::get('department', [DepartmentController::class, 'index'])->name('department');
        Route::post('department/add', [DepartmentController::class, 'store'])->name('addDepartment');
        Route::get('department/edit/{id}', [DepartmentController::class, 'edit']);
        Route::post('department/update/{id}', [DepartmentController::class, 'update']);
        Route::get('department/delete/{id}', [DepartmentController::class, 'delete']);

        // Group
        Route::get('group', [GroupController::class, 'index'])->name('group');
        Route::post('group/add', [GroupController::class, 'store'])->name('addGroup');
        Route::get('group/edit/{id}', [GroupController::class, 'edit']);
        Route::post('group/update/{id}', [GroupController::class, 'update']);
        Route::get('group/delete/{id}', [GroupController::class, 'delete']);

        // Import Data Excel&Csv
        Route::get('data-import', [DataImportController::class, 'index'])->name('data-import');
        Route::post('import', [DataImportController::class, 'import'])->name('import-list');
        Route::post('data-import/add', [DataImportController::class, 'store'])->name('addUserData');
        Route::get('data-import/edit/{id}', [DataImportController::class, 'edit']);
        Route::post('data-import/update/{id}', [DataImportController::class, 'update']);
        Route::get('data-import/delete/{id}', [DataImportController::class, 'delete']);

        // Import Device Excel&Csv
        Route::get('device/import', [DeviceImportController::class, 'index'])->name('device-import');
        Route::post('import-device', [DeviceImportController::class, 'import'])->name('import-device');

        // Import Stock Excel&Csv
        Route::get('stock/import', [StockImportController::class, 'index'])->name('stock-import');
        Route::post('import-stock', [StockImportController::class, 'import'])->name('import-stock');

        // Import Disposable Excel&Csv
        Route::get('disposable/import', [DisposableImportController::class, 'index'])->name('disposable-import');
        Route::post('import-disposable', [DisposableImportController::class, 'import'])->name('import-disposable');

        // Confirm
        Route::get('confirm-form', [ConfirmFormController::class, 'index'])->name('confirm-form');
        Route::post('confirm-form/update/{id}', [ConfirmFormController::class, 'update']);
        Route::post('confirm-form/add', [ConfirmFormController::class, 'create'])->name('form-add');

        // Return
        Route::get('confirm-return', [ConfirmReturnController::class, 'index'])->name('confirm-return');
        Route::post('confirm-return/update/{id}', [ConfirmReturnController::class, 'update']);

        Route::get('confirm-user', [ConfirmUserController::class, 'index'])->name('form-detail');

        // Report All
        Route::get('reportAll', [reportAllController::class, 'index'])->name('reportAll');
        Route::get('report-all/report_days', [reportAllController::class, 'reportDays'])->name('report-days');
        Route::get('report-all/report_months', [reportAllController::class, 'reportMonths'])->name('report-months');
        Route::get('report-all/report_terms', [reportAllController::class, 'reportTerms'])->name('report-terms');

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
         Route::get('/data-import/export-xlsm', [DataImportController::class,'exportXlsm'])->name('user_report_xlsm');
         Route::get('/report-all/export-day', [reportAllController::class, 'exportDay'])->name('report_day_xlsm');
         Route::get('/report-all/export-month', [reportAllController::class, 'exportMonth'])->name('report_month_xlsm');
         Route::get('/report-all/export-term', [reportAllController::class, 'exportTerm'])->name('report_term_xlsm');
    });

    Route::group(['middleware' => 'role:personnel'], function () {
        Route::get('personnel_dashboard', [\App\Http\Controllers\Personnel\DashboardController::class, 'index'])->name('personnel_dashboard');
        Route::post('personnel_dashboard/update/{id}', [\App\Http\Controllers\Personnel\DashboardController::class, 'update']);

        Route::get('personnel_borrow_stock', [\App\Http\Controllers\Personnel\CartController::class, 'cartList'])->name('personnel_borrow_stock.list');
        Route::post('personnel_borrow_stock/borrow', [\App\Http\Controllers\Personnel\CartController::class, 'addToCart'])->name('personnel_borrow_stock.add');
        Route::post('personnel_borrow_stock/update-cart', [\App\Http\Controllers\Personnel\CartController::class, 'updateCart'])->name('personnel_borrow_stock.update');
        Route::post('personnel_borrow_stock/remove', [\App\Http\Controllers\Personnel\CartController::class, 'removeCart'])->name('personnel_borrow_stock.remove');
        Route::get('personnel_borrow_stock/clear', [\App\Http\Controllers\Personnel\CartController::class, 'clearAllCart'])->name('personnel_borrow_stock.clear');
        Route::post('personnel_borrow_stock/save', [\App\Http\Controllers\Personnel\CartController::class, 'saveCart'])->name('personnel_borrow_stock.save');
        Route::post('personnel_borrow_stock/fetch', [\App\Http\Controllers\Personnel\CartController::class, 'fetch'])->name('personnel_borrow_stock.fetch');

        Route::get('personnel_borrow_disposable', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'cartList'])->name('personnel_borrow_disposable.list');
        Route::post('personnel_borrow_disposable/borrow', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'addToCart'])->name('personnel_borrow_disposable.add');
        Route::post('personnel_borrow_disposable/update-cart', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'updateCart'])->name('personnel_borrow_disposable.update');
        Route::post('personnel_borrow_disposable/remove', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'removeCart'])->name('personnel_borrow_disposable.remove');
        Route::get('personnel_borrow_disposable/clear', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'clearAllCart'])->name('personnel_borrow_disposable.clear');
        Route::post('personnel_borrow_disposable/save', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'saveCart'])->name('personnel_borrow_disposable.save');
        Route::post('personnel_borrow_disposable/fetch', [\App\Http\Controllers\Personnel\BorrowDisposable::class, 'fetch'])->name('personnel_borrow_disposable.fetch');

    });
    Route::group(['middleware' => 'role:student'], function () {
        Route::get('student_dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student_dashboard');
        Route::post('student_dashboard/update/{id}', [\App\Http\Controllers\Student\DashboardController::class, 'update']);
        // borrow stock
        Route::get('student_borrow_stock', [\App\Http\Controllers\Student\CartController::class, 'cartList'])->name('student_borrow_stock.list');
        Route::post('student_borrow_stock/borrow', [\App\Http\Controllers\Student\CartController::class, 'addToCart'])->name('student_borrow_stock.add');
        Route::post('student_borrow_stock/update-cart', [\App\Http\Controllers\Student\CartController::class, 'updateCart'])->name('student_borrow_stock.update');
        Route::post('student_borrow_stock/remove', [\App\Http\Controllers\Student\CartController::class, 'removeCart'])->name('student_borrow_stock.remove');
        Route::get('student_borrow_stock/clear', [\App\Http\Controllers\Student\CartController::class, 'clearAllCart'])->name('student_borrow_stock.clear');
        Route::post('student_borrow_stock/save', [\App\Http\Controllers\Student\CartController::class, 'saveCart'])->name('student_borrow_stock.save');
        Route::post('student_borrow_stock/fetch', [\App\Http\Controllers\Student\CartController::class, 'fetch'])->name('student_borrow_stock.fetch');
        // borrow disposable
        Route::get('student_borrow_disposable', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'cartList'])->name('student_borrow_disposable.list');
        Route::post('student_borrow_disposable/borrow', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'addToCart'])->name('student_borrow_disposable.add');
        Route::post('student_borrow_disposable/update-cart', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'updateCart'])->name('student_borrow_disposable.update');
        Route::post('student_borrow_disposable/remove', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'removeCart'])->name('student_borrow_disposable.remove');
        Route::get('student_borrow_disposable/clear', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'clearAllCart'])->name('student_borrow_disposable.clear');
        Route::post('student_borrow_disposable/save', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'saveCart'])->name('student_borrow_disposable.save');
        Route::post('student_borrow_disposable/fetch', [\App\Http\Controllers\Student\BorrowDisposableController::class, 'fetch'])->name('student_borrow_disposable.fetch');

    });

    // Search
    Route::get('people', [SearchController::class, 'index'])->name('search');
    Route::get('people/simple', [SearchController::class, 'simple'])->name('simple_search');
    Route::get('people/advance', [SearchController::class, 'advance'])->name('advance_search');

});
