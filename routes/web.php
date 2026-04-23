<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PpicController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */
Route::middleware('role:super_admin')->group(function () {
    Route::get('/superadmin/dashboard', [AdminController::class, 'dashboard'])
        ->name('superadmin.dashboard');

    Route::get('/superadmin/users', [AdminController::class, 'users'])
        ->name('superadmin.users');
    Route::post('/superadmin/users', [AdminController::class, 'storeUser'])
        ->name('superadmin.users.store');
    Route::put('/superadmin/update/{id}', [AdminController::class, 'update'])
        ->name('superadmin.users.update');
    Route::delete('/superadmin/delete/{id}', [AdminController::class, 'delete'])
        ->name('superadmin.users.delete');


    Route::get('/superadmin/departments', [AdminController::class, 'departments'])
        ->name('superadmin.departments');
    Route::post('/superadmin/departments', [AdminController::class, 'storeDepartment'])
        ->name('superadmin.departments.store');
    Route::put('/superadmin/departments/update/{id}', [AdminController::class, 'updateDepartment'])
        ->name('superadmin.departments.update');
    Route::delete('/superadmin/departments/delete/{id}', [AdminController::class, 'deleteDepartment'])
        ->name('superadmin.departments.delete');

    Route::get('/superadmin/monitoring', [AdminController::class, 'monitoring'])
        ->name('superadmin.monitoring');
});
/*
    |--------------------------------------------------------------------------
    | MANAGER
    |--------------------------------------------------------------------------
    */
Route::middleware('role:manager')->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])
        ->name('manager.dashboard');
    Route::get('/manager/monitoring', [ManagerController::class, 'monitoring'])
        ->name('manager.monitoring');
    Route::get('/manager/monitoring/{id}', [ManagerController::class, 'detailMonitoring'])
        ->name('manager.detailmonitoring');
    Route::get('/manager/report', [ManagerController::class, 'report'])
        ->name('manager.report');
    Route::get('/manager/report/export', [ManagerController::class, 'exportReport'])
        ->name('manager.report.export');
    Route::get('/manager/report/{id}', [ManagerController::class, 'show'])
        ->name('manager.show');


    // Route::get('/manager/report/{id}', [ManagerController::class, 'detailReport'])
    //     ->name('manager.detailreport');
});

/*
    |--------------------------------------------------------------------------
    | PPIC
    |--------------------------------------------------------------------------
    */
Route::middleware('role:ppic')->group(function () {
    Route::get('/ppic/dashboard', [PpicController::class, 'dashboard'])->name('ppic.dashboard');

    Route::get('/ppic/customer', [PpicController::class, 'customer'])->name('ppic.customer');
    Route::post('/ppic/customer', [PpicController::class, 'customerStore'])->name('ppic.customer.store');
    Route::put('/ppic/customer/update/{id}', [PpicController::class, 'customerUpdate'])->name('ppic.customer.update');
    Route::delete('/ppic/customer/delete/{id}', [PpicController::class, 'customerDelete'])->name('ppic.customer.delete');

    Route::get('/ppic/category', [PpicController::class, 'category'])->name('ppic.category');
    Route::delete('/ppic/category/delete/{id}', [PpicController::class, 'categoryDelete'])->name('ppic.category.delete');
    Route::put('/ppic/category/update/{id}', [PpicController::class, 'categoryUpdate'])->name('ppic.category.update');
    Route::post('/ppic/category', [PpicController::class, 'categoryStore'])->name('ppic.category.store');

    Route::get('/ppic/style', [PpicController::class, 'style'])->name('ppic.style');
    Route::post('/ppic/style', [PpicController::class, 'styleStore'])->name('ppic.style.store');
    Route::put('/ppic/style/update/{id}', [PpicController::class, 'styleUpdate'])->name('ppic.style.update');
    Route::delete('ppic/style/delete/{id}', [PpicController::class, 'styleDelete'])->name('ppic.style.delete');

    Route::get('/ppic/color', [PpicController::class, 'color'])->name('ppic.color');
    Route::post('/ppic/color', [PpicController::class, 'colorStore'])->name('ppic.color.store');
    Route::put('/ppic/color/update/{id}', [PpicController::class, 'colorUpdate'])->name('ppic.color.update');
    Route::delete('/ppic/color/delete/{id}', [PpicController::class, 'colorDelete'])->name('ppic.color.delete');

    Route::get('/ppic/item', [PpicController::class, 'item'])->name('ppic.item');
    Route::post('/ppic/item', [PpicController::class, 'itemStore'])->name('ppic.item.store');
    Route::put('/ppic/item/update/{id}', [PpicController::class, 'itemUpdate'])->name('ppic.item.update');
    Route::delete('/ppic/item/delete/{id}', [PpicController::class, 'itemDelete'])->name('ppic.item.delete');

    Route::get('/ppic/brand', [PpicController::class, 'brand'])->name('ppic.brand');
    Route::post('/ppic/brand', [PpicController::class, 'brandStore'])->name('ppic.brand.store');
    Route::put('/ppic/brand/update/{id}', [PpicController::class, 'brandUpdate'])->name('ppic.brand.update');
    Route::delete('/ppic/brand/delete/{id}', [PpicController::class, 'brandDelete'])->name('ppic.brand.delete');

    Route::get('/ppic/unit', [PpicController::class, 'unit'])->name('ppic.unit');
    Route::post('/ppic/unit', [PpicController::class, 'unitStore'])->name('ppic.unit.store');
    Route::put('/ppic/unit/update/{id}', [PpicController::class, 'unitUpdate'])->name('ppic.unit.update');
    Route::delete('/ppic/unit/delete/{id}', [PpicController::class, 'unitDelete'])->name('ppic.unit.delete');

    Route::get('/ppic/currency', [PpicController::class, 'currency'])->name('ppic.currency');
    Route::post('/ppic/currency', [PpicController::class, 'currencyStore'])->name('ppic.currency.store');
    Route::put('/ppic/currency/update/{id}', [PpicController::class, 'currencyUpdate'])->name('ppic.currency.update');
    Route::delete('/ppic/currency/delete/{id}', [PpicController::class, 'currencyDelete'])->name('ppic.currency.delete');

    Route::get('/ppic/kkpo', [PpicController::class, 'kkpo'])->name('ppic.kkpo');
    Route::post('/ppic/kkpo', [PpicController::class, 'kkpoStore'])->name('ppic.kkpo.store');
    Route::put('/ppic/kkpo/update/{id}', [PpicController::class, 'kkpoUpdate'])->name('ppic.kkpo.update');
    Route::delete('/ppic/kkpo/delete/{id}', [PpicController::class, 'kkpoDelete'])->name('ppic.kkpo.delete');

    Route::get('/ppic/kkpomanagement', [PpicController::class, 'kkpoManagement'])->name('ppic.kkpomanagement');
    Route::post('/ppic/kkpomanagement', [PpicController::class, 'kkpoManagementStore'])->name('ppic.kkpomanagement.store');
    Route::get('/ppic/kkpomanagement/{id}', [PpicController::class, 'kkpoManagementShow'])->name('ppic.kkpomanagement.show');
    // Route::get('/ppic/kkpomanagement/detail/{id}', [PpicController::class, 'kkpoDetail'])->name('ppic.kkpomanagement.detail');
    Route::put('/ppic/kkpomanagement/update/{id}', [PpicController::class, 'kkpoManagementUpdate'])->name('ppic.kkpomanagement.update');
    Route::delete('/ppic/kkpomanagement/delete/{id}', [PpicController::class, 'kkpoManagementDelete'])->name('ppic.kkpomanagement.delete');

    Route::get('/ppic/monitoring', [PpicController::class, 'monitoring'])->name('ppic.monitoring');
});

/*
    |--------------------------------------------------------------------------
    | WAREHOUSE
    |--------------------------------------------------------------------------
    */
Route::middleware('role:warehouse')->group(function () {
    Route::get('/warehouse/dashboard', [WarehouseController::class, 'dashboard'])->name('warehouse.dashboard');

    Route::get('/warehouse/order', [WarehouseController::class, 'order'])->name('warehouse.suratjalan');
    Route::post('/warehouse/order', [WarehouseController::class, 'orderStore'])->name('warehouse.suratjalan.store');
    Route::put('/warehouse/order/update/{id}', [WarehouseController::class, 'orderUpdate'])->name('warehouse.suratjalan.update');
    Route::delete('/warehouse/order/delete/{id}', [WarehouseController::class, 'orderDelete'])->name('warehouse.suratjalan.delete');

    Route::get('/warehouse/pecah', [WarehouseController::class, 'pecah'])->name('warehouse.pecah');
    Route::post('/warehouse/pecah', [WarehouseController::class, 'pecahStore'])->name('warehouse.pecah.store');
    Route::put('/warehouse/pecah/update/{id}', [WarehouseController::class, 'pecahUpdate'])->name('warehouse.pecah.update');
    Route::delete('/warehouse/pecah/delete/{id}', [WarehouseController::class, 'pecahDelete'])->name('warehouse.pecah.delete');

    Route::get('/warehouse/list', [WarehouseController::class, 'list'])->name('warehouse.list');
    // Route::get('/warehouse/rework', [WarehouseController::class, 'rework'])->name('warehouse.rework');
    Route::post('/warehouse/rework/{id}', [WarehouseController::class, 'reworkStore'])->name('warehouse.rework.store');
});

/*
    |--------------------------------------------------------------------------
    | OPERATOR
    |--------------------------------------------------------------------------
    */
Route::middleware('role:produksi')->group(function () {
    Route::get('/produksi/dashboard', [ProductionController::class, 'dashboard'])->name('produksi.dashboard');

    Route::get('/produksi', [ProductionController::class, 'index'])->name('produksi.proses.index');
    Route::get('/produksi/suratjalanout', [ProductionController::class, 'suratJalanOut'])->name('produksi.suratjalanout.index');
    Route::post('/produksi/suratjalanout/create/', [ProductionController::class, 'suratJalanOutStore'])->name('produksi.suratjalanout.store');

    Route::get('/produksi/suratjalanout/create/{id}', [ProductionController::class, 'createSuratJalanOut'])->name('produksi.suratjalanout.create');

    Route::get('/produksi/log', [ProductionController::class, 'logProduction'])->name('produksi.logproduksi');
    Route::get('/produksi/log/{id}', [ProductionController::class, 'logDetail'])->name('produksi.logdetail');

    Route::get('/produksi/{id}', [ProductionController::class, 'process'])->name('produksi.proses.process');
    Route::post('/produksi/in', [ProductionController::class, 'storeIn'])->name('produksi.in.store');
    Route::post('/produksi/out', [ProductionController::class, 'storeOut'])->name('produksi.out.store');


    // Route::get('/produksi/datain', [ProductionController::class, 'dataIn'])->name('produksi.datain');
    // Route::get('/produksi/dataout', [ProductionController::class, 'dataOut'])->name('produksi.dataout');
    // Route::get('/produksi/listapprove', [ProductionController::class, 'listapprove'])->name('produksi.listapprove');
    // Route::get('/produksi/listproblem', [ProductionController::class, 'listproblem'])->name('produksi.listproblem');

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
