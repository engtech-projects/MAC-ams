<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProductsServicesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SystemSetupController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\UserProfileController;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

// LoginController
Route::get('/', [LoginController::class, 'index']);
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout',[LoginController::class, 'userLogout'])->name('logout');
Route::post('authenticate', [LoginController::class, 'authenticate'])->name('login.user');
// DashboardController
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// AccountsController
Route::resource('accounts', AccountsController::class);
Route::get('accounts-datatable', [AccountsController::class, 'populate'])->name('accounts.populate');
Route::post('set-status', [AccountsController::class, 'setStatus'])->name('accounts.setStatus');
Route::post('accounts/import', [AccountsController::class, 'import'])->name('accounts.import');

// CustomerController
Route::get('sales/customers', [CustomerController::class, 'index'])->name('sales.customers');
Route::get('sales/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('sales/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::post('sales/customer/update', [CustomerController::class, 'update'])->name('customer.update');
Route::get('sales/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
Route::get('customer-datatable', [CustomerController::class, 'populate'])->name('customer.populate');

// EmployeesController
Route::get('employees', [EmployeesController::class, 'index'])->name('employees');
Route::get('employees-datatable', [EmployeesController::class, 'employeesDataTable'])->name('employees.datatable');
Route::get('employee/create', [EmployeesController::class, 'create'])->name('employee.create');
Route::post('employee/store', [EmployeesController::class, 'store'])->name('employee.store');
Route::post('employee/update', [EmployeesController::class, 'update'])->name('employee.update');
Route::get('employee/{id}/edit', [EmployeesController::class, 'edit'])->name('employee.edit');

// ProductsServicesController
Route::get('products_and_services', [ProductsServicesController::class, 'index'])->name('products_services');
Route::get('products_and_services/fetch', [ProductsServicesController::class, 'fetchDataTable'])->name('products_services.datatable');
Route::get('product/create', [ProductsServicesController::class, 'createProduct'])->name('product.create');
Route::get('product/{id}/edit', [ProductsServicesController::class, 'editProduct'])->name('product.edit');
Route::get('service/{id}/edit', [ProductsServicesController::class, 'editService'])->name('service.edit');
Route::post('product/store', [ProductsServicesController::class, 'storeProduct'])->name('product.store');
Route::post('product/update', [ProductsServicesController::class, 'updateProduct'])->name('product.update');
Route::get('product/category/create', [ProductsServicesController::class, 'createProductCategory'])->name('product.category.create');
Route::get('product/categories/fetch', [ProductsServicesController::class, 'fetchProductCategories'])->name('product.categories.fetch');
Route::post('product/category/store', [ProductsServicesController::class, 'storeProductCategory'])->name('product.category.store');
Route::post('product/category/delete', [ProductsServicesController::class, 'deleteProductCategory'])->name('product.category.delete');
Route::post('product/category/update', [ProductsServicesController::class, 'updateProductCategory'])->name('product.category.update');
Route::post('service/update', [ProductsServicesController::class, 'updateService'])->name('service.update');
Route::get('service/create', [ProductsServicesController::class, 'createService'])->name('service.create');
Route::post('service/store', [ProductsServicesController::class, 'storeService'])->name('service.store');

// ExpensesController
Route::get('expenses', [ExpensesController::class, 'index'])->name('expenses');
Route::get('create/{type}', [ExpensesController::class, 'create'])->name('expenses.create');
Route::get('show/{type}', [ExpensesController::class, 'show'])->name('expenses.show');
Route::post('expenses/store', [ExpensesController::class, 'store'])->name('expenses.store');
Route::post('expenses/void', [ExpensesController::class, 'void'])->name('expenses.void');
Route::post('expense-datatable', [ExpensesController::class, 'populate'])->name('expenses.populate');

// system setup
Route::get('systemSetup', [SystemSetupController::class, 'index'])->name('systemSetup');
Route::post('systemSetup/general/usermasterfile/createOrUpdate', [SystemSetupController::class, 'userMasterFileCreateOrUpdate'])->name('SystemSetupController.userMasterFile.createOrUpdate');
Route::post('systemSetup/general/usermasterfile/createOrUpdateAccessibility', [SystemSetupController::class, 'userMasterFileCreateOrUpdateAccessibility'])->name('SystemSetupController.usermasterfile.createOrUpdateAccessibility');
Route::get('systemSetup/general/usermasterfile/searchAccount', [SystemSetupController::class, 'searchAccount'])->name('SystemSetupController.usermasterfile.searchAccount');
Route::get('systemSetup/general/usermasterfile/fetchInfo', [SystemSetupController::class, 'fetchInfo'])->name('SystemSetupController.usermasterfile.fetchInfo');

Route::post('systemSetup/general/company/update', [SystemSetupController::class, 'companyUpdate'])->name('SystemSetupController.company.update');
Route::post('systemSetup/general/accounting/update', [SystemSetupController::class, 'accountingUpdate'])->name('SystemSetupController.accounting.update');
Route::post('systemSetup/general/currency/update', [SystemSetupController::class, 'currencyUpdate'])->name('SystemSetupController.currency.update');

// supplier
Route::resource('supplier', SupplierController::class);
Route::get('supplier-datatable', [SupplierController::class, 'populate'])->name('supplier.populate');

// sales
Route::get('sales', [SalesController::class, 'index'])->name('sales');
Route::get('sales/create/{type}', [SalesController::class, 'create'])->name('sales.create');
Route::post('sales/store', [SalesController::class, 'store'])->name('sales.store');
Route::post('sales-datatable', [SalesController::class, 'populate'])->name('sales.populate');
Route::get('getsales', [SalesController::class, 'load'])->name('sales.load');
Route::get('sales/invoice', [SalesController::class, 'invoice'])->name('sales.invoice');

// payment
Route::get('payment/create/{id}', [PaymentController::class, 'create'])->name('payment.create');
Route::get('payment/customer/{id}', [PaymentController::class, 'customerPayment'])->name('payment.customer');
// Route::get('payment/invoice', [PaymentController::class, ''])->name('');
// Route::get('payment/supplier', [PaymentController::class, ''])->name('');
// Route::get('payment/bill', [PaymentController::class, ''])->name('');
Route::post('payment/store', [PaymentController::class, 'store'])->name('payment.store');

// journal
Route::get('journal', [JournalController::class, 'create'])->name('journal.create');
Route::post('journal', [JournalController::class, 'store'])->name('journal.store');

// User Profile
Route::get('user/profile', [UserProfileController::class, 'index'])->name('user.profile');
Route::post('user/profile/username/update', [UserProfileController::class, 'updateUsername'])->name('username.update');
Route::post('user/profile/password/update', [UserProfileController::class, 'updatePassword'])->name('password.update');
