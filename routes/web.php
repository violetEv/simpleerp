<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KkpoController;
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
        ->name('superadmin.user');
    Route::post('/superadmin/users', [AdminController::class, 'storeUser'])
        ->name('superadmin.user.store');
    Route::put('/superadmin/update/{id}', [AdminController::class, 'update'])
        ->name('superadmin.user.update');
    Route::delete('/superadmin/delete/{id}', [AdminController::class, 'delete'])
        ->name('superadmin.user.delete');


    Route::get('/superadmin/departments', [AdminController::class, 'departments'])
        ->name('superadmin.department');
    Route::post('/superadmin/departments', [AdminController::class, 'storeDepartment'])
        ->name('superadmin.department.store');
    Route::put('/superadmin/departments/update/{id}', [AdminController::class, 'updateDepartment'])
        ->name('superadmin.department.update');
    Route::delete('/superadmin/departments/delete/{id}', [AdminController::class, 'deleteDepartment'])
        ->name('superadmin.department.delete');

    Route::get('/superadmin/machines', [AdminController::class, 'machines'])
        ->name('superadmin.machine');
    Route::post('/superadmin/machines', [AdminController::class, 'storeMachine'])
        ->name('superadmin.machine.store');
    Route::put('/superadmin/machines/update/{id}', [AdminController::class, 'updateMachine'])
        ->name('superadmin.machine.update');
    Route::delete('/superadmin/machines/delete/{id}', [AdminController::class, 'deleteMachine'])
        ->name('superadmin.machine.delete');

    Route::get('/superadmin/monitoring', [AdminController::class, 'travelerMonitoring'])
        ->name('superadmin.monitoring');

    Route::get('/superadmin/report', [AdminController::class, 'report'])
        ->name('superadmin.report');
        Route::get('/superadmin/report/export', [AdminController::class, 'exportReport'])
        ->name('superadmin.report.export');
    Route::get('/superadmin/approval', [AdminController::class, 'approval'])
        ->name('superadmin.approval');
     // Route::get('/superadmin/activitylog', [AdminController::class, 'activityLog'])->name('superadmin.activitylog');
     // Route::get('/superadmin/settings', [AdminController::class, 'settings'])->name('superadmin.settings');
});
/*
    |--------------------------------------------------------------------------
    | MANAGER
    |--------------------------------------------------------------------------
    */
Route::middleware('role:manager')->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])
        ->name('manager.dashboard');
    Route::get('/manager/monitoring', [ManagerController::class, 'traveler'])
        ->name('manager.monitoring');
    Route::get('/manager/monitoring/{id}', [ManagerController::class, 'detailMonitoring'])
        ->name('manager.detailmonitoring');

    Route::get('/manager/report', [ManagerController::class, 'report'])
        ->name('manager.report');
    Route::get('/manager/report/export', [ManagerController::class, 'exportReport'])
        ->name('manager.report.export');
    Route::get('/manager/report/{id}', [ManagerController::class, 'show'])
        ->name('manager.report.show');
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
    Route::post('/ppic/customer/import', [PpicController::class, 'import'])->name('ppic.customer.import');
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

    Route::get('/ppic/kkpo', [KkpoController::class, 'kkpo'])->name('ppic.kkpo');
    Route::post('/ppic/kkpo', [KkpoController::class, 'kkpoStore'])->name('ppic.kkpo.store');
    Route::get('/ppic/kkpo/check', [KkpoController::class, 'check'])->name('ppic.kkpo.check');
    Route::put('/ppic/kkpo/update/{id}', [KkpoController::class, 'kkpoUpdate'])->name('ppic.kkpo.update');
    Route::delete('/ppic/kkpo/delete/{id}', [KkpoController::class, 'kkpoDelete'])->name('ppic.kkpo.delete');

    Route::get('/ppic/kkpo/{id}', [KkpoController::class, 'kkpoDetailShow'])->name('ppic.kkpodetail.show');

    Route::get('/ppic/monitoring', [PpicController::class, 'travelerMonitoring'])->name('ppic.monitoring');

    Route::get('/ppic/report', [PpicController::class, 'report'])
        ->name('ppic.report');
    Route::get('/ppic/report/export', [PpicController::class, 'exportReport'])
        ->name('ppic.report.export');
    Route::get('/ppic/report/{id}', [PpicController::class, 'show'])
        ->name('ppic.report.show');
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

    Route::get('/warehouse/list-new', [WarehouseController::class, 'list'])->name('warehouse.list-new');
    Route::put('/warehouse/list-new/update/{id}', [WarehouseController::class, 'editTraveler'])->name('warehouse.list-new.update');
    Route::get('/warehouse/list-new/{id}', [WarehouseController::class, 'travelerDetail'])->name('warehouse.list-new.show');
    Route::delete('/warehouse/list-new/delete/{id}', [WarehouseController::class, 'travelerDelete'])->name('warehouse.list-new.delete');
    // Route::get('/warehouse/rework', [WarehouseController::class, 'rework'])->name('warehouse.rework');
    Route::get('/warehouse/list-rework', [WarehouseController::class, 'rework'])->name('warehouse.list-rework');

    Route::post('/warehouse/list-rework/{id}', [WarehouseController::class, 'reworkStore'])->name('warehouse.rework.store');

    Route::get('/warehouse/log-warehouse', [WarehouseController::class, 'logWarehouse'])->name('warehouse.log-warehouse');
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
    Route::post('/produksi/suratjalanout/store', [ProductionController::class, 'suratJalanOutStore'])->name('produksi.suratjalanout.store');
    Route::put('/produksi/suratjalanout/update/{id}', [ProductionController::class, 'updateSuratJalanOut'])->name('produksi.suratjalanout.update');
    Route::delete('/produksi/suratjalanout/delete/{id}', [ProductionController::class, 'deleteSuratJalanOut'])->name('produksi.suratjalanout.delete');

    // Route::get('/produksi/suratjalanout/create/{id}', [ProductionController::class, 'createSuratJalanOut'])->name('produksi.suratjalanout.create');

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
