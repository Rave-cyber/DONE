<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\ServicePriceController;
use App\Http\Controllers\Employee\Supplier_Controller;
use App\Http\Controllers\Inventory\ReceiveOrderController;
use App\Http\Controllers\Employee\Items_Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\OrderTrackingController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order routes with payment integration
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        
        // Status management
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('status.update');
        
        // Payment routes
        Route::get('/{order}/payment', [OrderController::class, 'showPaymentForm'])->name('payment.form');
        Route::post('/{order}/process-payment', [OrderController::class, 'processPayment'])->name('payment.process');
        Route::put('/{order}/mark-paid', [OrderController::class, 'markAsPaid'])->name('mark-paid');
        
        // Archive management
        Route::put('/{order}/archive', [OrderController::class, 'archiveOrder'])->name('archive');
        Route::put('/{order}/unarchive', [OrderController::class, 'unarchiveOrder'])->name('unarchive');
        
        // Tracking
        Route::get('/{order}/tracking', [OrderController::class, 'tracking'])->name('tracking');
        
        // Employee assignment
        Route::get('/{order}/assign', [OrderController::class, 'showAssignForm'])->name('assign.form');
        Route::post('/{order}/assign', [OrderController::class, 'assignEmployees'])->name('assign');
    });

    // Transaction routes
    Route::resource('transactions', TransactionController::class);
});

// API route for service prices
Route::get('/api/service-prices', [TransactionController::class, 'getServicePrices'])->name('api.service-prices');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Employee management
    Route::resource('employees', EmployeeController::class)->names([
        'index' => 'admin.employee.index',
        'create' => 'admin.employee.create',
        'store' => 'admin.employee.store',
        'show' => 'admin.employee.show',
        'edit' => 'admin.employee.edit',
        'update' => 'admin.employee.update',
        'destroy' => 'admin.employee.destroy',
    ]);

    // Supplier management
    Route::resource('suppliers', SupplierController::class)->names([
        'index' => 'admin.suppliers.index',
        'create' => 'admin.suppliers.create',
        'store' => 'admin.suppliers.store',
        'show' => 'admin.suppliers.show',
        'edit' => 'admin.suppliers.edit',
        'update' => 'admin.suppliers.update',
        'destroy' => 'admin.suppliers.destroy',
    ]);
    
    Route::post('suppliers/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])
        ->name('admin.suppliers.toggle-status');    
        
    // Inventory management
    Route::resource('inventory', InventoryController::class)->names([
        'index' => 'admin.inventory.index',
        'create' => 'admin.inventory.create',
        'store' => 'admin.inventory.store',
        'show' => 'admin.inventory.show',
        'edit' => 'admin.inventory.edit',
        'update' => 'admin.inventory.update',
        'destroy' => 'admin.inventory.destroy',
    ]);    
    
    // Price management
    Route::put('/prices/update', [TransactionController::class, 'updatePrices'])
        ->name('admin.prices.update');
        
    // Service prices
    Route::prefix('service-prices')->name('service-prices.')->group(function() {
        Route::get('/', [ServicePriceController::class, 'index'])->name('index');
        Route::get('/json', [ServicePriceController::class, 'getJson'])->name('json');
    });

    // Sales reports
    Route::prefix('sales_report')->name('admin.sales_report.')->group(function () {
        Route::get('/', [SalesReportController::class, 'index'])->name('index');
        Route::post('/generate', [SalesReportController::class, 'generate'])->name('generate');
        Route::post('/export/excel', [SalesReportController::class, 'exportExcel'])->name('export.excel');
        Route::post('/export/pdf', [SalesReportController::class, 'exportPDF'])->name('export.pdf');
    });
});

// Employee routes
Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
    // Supplier routes
    Route::resource('supplier', Supplier_Controller::class)->only(['index', 'show'])->names([
        'index' => 'supplier.index',
        'show' => 'supplier.show',
    ]);
    
    // Inventory items
    Route::resource('inventoryitem', Items_Controller::class)->names([
        'index' => 'items.index',
        'create' => 'items.create',
        'store' => 'items.store',
        'show' => 'items.show',
        'edit' => 'items.edit',
        'update' => 'items.update',
        'destroy' => 'items.destroy',
    ]);

    // Stock management
    Route::get('/stock/in', [StockController::class, 'stockInForm'])->name('stock-in.form');
    Route::post('/stock/in', [StockController::class, 'stockIn'])->name('stock-in');
    Route::get('/stock-in', [StockController::class, 'index'])->name('stock_in_index');
    Route::get('/stock-in/purchase-order/{id}', [StockController::class, 'stockInFromReceiveOrderForm'])->name('stock-in.from-ro');
    Route::post('/stock-in/purchase-order/{id}', [StockController::class, 'stockInFromReceiveOrderSubmit'])->name('stock-in.from-ro.submit');

    // Receive orders
    Route::resource('receive-orders', ReceiveOrderController::class)->names([
        'index' => 'receive-orders.index',
        'create' => 'receive-orders.create',
        'store' => 'receive-orders.store',
        'show' => 'receive-orders.show',
        'edit' => 'receive-orders.edit',
        'update' => 'receive-orders.update',
        'destroy' => 'receive-orders.destroy',
    ]);

    // Stock out
    Route::get('/stock-out/create', [StockController::class, 'stockOutForm'])->name('stock-out.form');
    Route::post('/stock-out', [StockController::class, 'stockOutSubmit'])->name('stock-out');
    Route::get('/stock-out', [StockController::class, 'stockOutIndex'])->name('stock_out_index');
});

// Order tracking
Route::get('/track-order', [OrderTrackingController::class, 'trackOrder'])
    ->name('track.order');

// Debug route to check order status
Route::get('/debug/order/{id}', function($id) {
    $order = \App\Models\Order::find($id);
    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }
    return response()->json([
        'id' => $order->id,
        'status' => $order->status,
        'payment_status' => $order->payment_status,
        'is_archived' => (bool)$order->is_archived,
        'created_at' => $order->created_at,
        'updated_at' => $order->updated_at
    ]);
});

require __DIR__.'/auth.php';