<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoiceArchicesController;

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

// Hello New Updates //
Route::get('/', function () {
    // return view('welcome');

    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [InvoicesController::class, 'indexDashboard'])->name('indexDashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';




Route::controller(SectionsController::class)->group(function () {

    Route::middleware('auth')->group(function () {

        Route::get('sections', 'index')->name('section_index');
        Route::post('sections', 'store')->name('section_store');
        Route::put('sections', 'update')->name('section_update');
        Route::delete('sections', 'destroy')->name('section_delete');
    });

});

Route::controller(ProductsController::class)->group(function () {

    Route::middleware('auth')->group(function () {

        Route::get('products', 'index')->name('product_index');
        Route::post('products', 'store')->name('product_store');
        Route::put('products', 'update')->name('product_update');
        Route::delete('products', 'destroy')->name('product_delete');
    });

});


Route::controller(InvoicesController::class)->group(function () {


    Route::middleware('auth')->group(function () {

        Route::get('invoices', 'index')->name('invoice_index');
        Route::get('paid_invoices', 'index_paid');
        Route::get('unpaid_invoices', 'index_unpaid');
        Route::get('part_paid_invoices', 'index_part_paid');
        Route::get('archiveInvoice/{id}', 'archive')->name('archive');
        Route::get('invoices/create', 'create')->name('invoice_create');
        Route::post('invoices', 'store')->name('invoice_store');
        Route::get('invoices/{id}', 'getProducts')->name('getProducts');
        Route::get('updateInvoice/{id}', 'edit')->name('invoice_update');
        Route::put('updateInvoice/{id}', 'update')->name('product_update');
        Route::delete('invoices/{id}', 'destroy')->name('invoice_delete');
        Route::get('paidinvoice/{id}', 'show')->name('invoice_paid');
        Route::put('paidinvoice/{id}', 'updateStatus')->name('invoice_update_status');
        Route::get('print_invoice/{id}', 'print_invoice')->name('print_invoice');
        Route::get('export', 'export')->name('export');

        Route::get('mark-as-read', 'markNotification')->name('markNotification');
    });




});


Route::controller(ReportsController::class)->group(function () {


    Route::middleware('auth')->group(function () {

        Route::get('invoiceReports', 'indexinvoiceReports')->name('invoiceReports');
        Route::POST('Search_invoices', 'Search_invoices')->name('Search_invoices');

        Route::get('CustomersReports', 'CustomersReports')->name('CustomersReports');
        Route::POST('Search_customers', 'Search_customers')->name('Search_customers');
        Route::get('sections/{id}', 'getProducts')->name('getProducts');

    });




});



Route::controller(InvoiceDetailsController::class)->group(function () {

    Route::middleware('auth')->group(function () {

        Route::get('invoiceDetails/{id}', 'index')->name('invoice_details_index');
        Route::get('showImage/{path}', 'showImage')->name('invoice_details_image');
        Route::get('download/{path}', 'downloadImage')->name('invoice_details_download_image');
        Route::get('deleteImage/{id}', 'destroy')->name('invoice_details_delete');
        Route::put('uploadattach', 'uploadAttachment')->name('uploadattach');
    });


});

Route::controller(InvoiceArchicesController::class)->group(function () {

    Route::middleware('auth')->group(function () {

        Route::get('archiveInvoice', 'index')->name('indexarchive');
        Route::get('backToInvoice/{id}', 'backToInvoice')->name('backToInvoice');
        Route::delete('archive_delete/{id}', 'destroy')->name('archive_delete');
    });

});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    // Route::resource('products', ProductController::class);
});

Route::fallback(function () {
    return view('404');
});