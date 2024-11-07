<?php

use App\Http\Controllers\User_Email_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\invoices_details_Controller;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

// Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// انتهاء

// // المستخدمين 
// route::get('users_email',[User_Email_Controller::class,'users_email'])->name('users');
// route::get('create_user',[User_Email_Controller::class,'create_user'])->name('create_user');
// route::post('store_user',[User_Email_Controller::class,'store_user'])->name('store_user');
// // انتهاء


// الفواتير
Route::resource('invoices', InvoiceController::class);
Route::get('section/{id}', [InvoiceController::class, 'getProducts'])->name('getProducts');
Route::get("edit/{id}", [InvoiceController::class, 'edit'])->name('edit.invoice');
route::post("update/{id}", [InvoiceController::class, 'update'])->name('update.invoice');
route::post("softDeletes/{id}", [InvoiceController::class, 'softDeletes'])->name('softDeletes.invoice');
route::get("forceDelete.invoice/{id}", [InvoiceController::class, 'forceDeleteGet'])->name('forceDeleteGet.invoice');
route::post("forceDelete.invoice/{id}", [InvoiceController::class, 'forceDeletePost'])->name('forceDeletePost.invoice');
route::get('status_edit/{id}', [InvoiceController::class, 'status_edit'])->name('status_edit');
route::post('status_update/{id}', [InvoiceController::class, 'status_update'])->name('status_update');
route::get('invoices_paid', [InvoiceController::class, 'invoices_paid'])->name('invoices_paid');
route::get('invoices_unpaid', [InvoiceController::class, 'invoices_unpaid'])->name('invoices_unpaid');
route::get('invoices_partial', [InvoiceController::class, 'invoices_partial'])->name('invoices_partial');
route::get('invoiceArchive', [InvoiceController::class, 'invoiceArchive'])->name('invoiceArchive');
route::post('invoiceRestore/{id}', [InvoiceController::class, 'invoiceRestore'])->name('invoiceRestore');


// تفاصيل الفاتورة invoices_details
route::get('invoices_details/{id}', [invoices_details_Controller::class, 'edit'])->name('invoices_details.edit');
route::get('view_file/{invoice_number}/{file_name}', [invoices_details_Controller::class, 'view_file'])->name('view_file');
route::post('delete/{id}', [invoices_details_Controller::class, 'destroy'])->name('delete_files');
// الاقسام
Route::resource('sections', SectionController::class);
// انتهاء 



Route::get('testRoute', function () {
    return "testRoute";
})->name('testRoute');

// المنتجات
Route::resource('products', ProductController::class);

// انتهاء



Route::resource('users', UserController::class);


Route::get('showUser', [UserController::class, 'showUser'])->name('showUser');


Route::get('invoiceReport',[InvoicesReportController::class,'index'])->name('invoiceReport');
Route::post('invoicesSearch',[InvoicesReportController::class,'invoicesSearch'])->name('invoicesSearch');