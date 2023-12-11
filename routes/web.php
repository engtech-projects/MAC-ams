<?php

use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\BranchController;

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


// LoginController
Route::get('/', [LoginController::class, 'index'])->name('/');
Route::get('get-token', function () {
    return response()->json(['data' => csrf_token()]);
});
Route::post('authenticate', [LoginController::class, 'authenticate'])->name('login.user');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LoginController::class, 'userLogout'])->name('logout');
Route::get('/me',[AuthController::class, 'getAuthUser'])->name('auth.user');
Route::get('branch',[BranchController::class, 'index'])->name('branch.list');

/* Route::post('authenticate', [LoginController::class, 'authenticate'])->name('login.user'); */
// DashboardController
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');



// AccountsController
Route::resource('accounts', AccountsController::class);
Route::get('accounts-datatable', [AccountsController::class, 'populate'])->name('accounts.populate');
Route::get('accounts/getAccountTypeContent', [AccountsController::class, 'getAccountTypeContent'])->name('accounts.getAccountTypeContent');
Route::post('accounts/saveType', [AccountsController::class, 'saveType'])->name('accounts.saveType');
Route::post('accounts/saveClass', [AccountsController::class, 'saveClass'])->name('accounts.saveClass');
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

Route::post('systemSetup/general/journalBook/createOrUpdate', [SystemSetupController::class, 'journalBookCreateOrUpdate'])->name('SystemSetupController.journalBook.createOrUpdate');
Route::get('systemSetup/general/journalBook/fetchBookInfo', [SystemSetupController::class, 'fetchBookInfo'])->name('SystemSetupController.journalBook.fetchBookInfo');
Route::get('systemSetup/general/journalBook/deleteBook', [SystemSetupController::class, 'deleteBook'])->name('SystemSetupController.journalBook.deleteBook');

Route::post('systemSetup/general/categoryFile/createOrUpdate', [SystemSetupController::class, 'categoryFileCreateOrUpdate'])->name('SystemSetupController.categoryFile.createOrUpdate');
Route::get('systemSetup/general/categoryFile/fetchCategoryInfo', [SystemSetupController::class, 'fetchCategoryInfo'])->name('SystemSetupController.categoryFile.fetchCategoryInfo');
Route::get('systemSetup/general/categoryFile/deleteCategory', [SystemSetupController::class, 'deleteCategoryFile'])->name('SystemSetupController.categoryFile.deleteCategory');


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


//reports
Route::get('reports/subsidiaryledger', [ReportsController::class, 'subsidiaryLedger'])->name('reports.subsidiaryledger');

Route::post('reports/subsidiary-ledger',[ReportsController::class, 'subsidiaryLedgerReports'])->name('reports.subsidiary-ledger');
Route::get('reports/subsidiary-ledger-listing',[ReportsController::class, 'subsidiaryListing'])->name('reports.subsidiary.listing');



Route::get('reports/subsidiaryViewInfo', [ReportsController::class, 'subsidiaryViewInfo'])->name('reports.subsidiaryViewInfo');
Route::get('reports/subsidiaryDelete', [ReportsController::class, 'subsidiaryDelete'])->name('reports.subsidiaryDelete');
Route::get('reports/generalLedger', [ReportsController::class, 'generalLedger'])->name('reports.generalLedger');
Route::get('reports/journal_entry', [ReportsController::class, 'journalEntry'])->name('reports.journal_entry');
Route::post('reports/generalLedgerFetchAccount', [ReportsController::class, 'generalLedgerFetchAccount'])->name('reports.generalLedgerFetchAccount');
Route::get('reports/trialBalance', [ReportsController::class, 'trialBalance'])->name('reports.trialBalance');
Route::get('reports/incomeStatement', [ReportsController::class, 'incomeStatement'])->name('reports.incomeStatement');
Route::get('reports/bankReconcillation', [ReportsController::class, 'bankReconcillation'])->name('reports.bankReconcillation');
Route::get('reports/journalledger', [ReportsController::class, 'journalLedger'])->name('reports.journalLedger');


Route::get('reports/cheque', [ReportsController::class, 'cheque'])->name('reports.cheque');
Route::get('reports/chartOfAccounts', [ReportsController::class, 'chartOfAccounts'])->name('reports.chartOfAccounts');
Route::get('reports/postDatedCheque', [ReportsController::class, 'postDatedCheque'])->name('reports.postDatedCheque');
Route::get('reports/cashPosition', [ReportsController::class, 'cashPosition'])->name('reports.cashPosition');
Route::get('reports/cashTransactionBlotter', [ReportsController::class, 'cashTransactionBlotter'])->name('reports.cashTransactionBlotter');
Route::post('reports/cashTransactionBlotter', [ReportsController::class, 'searchCashTransactionBlotter'])->name('reports.searchTransactionBlotter');
Route::post('reports/cashTransactionBlotter/{id}', [ReportsController::class, 'showCashTransactionBlotter'])->name('reports.showCashBlotter');

Route::post('reports/subsidiarySaveorEdit', [ReportsController::class, 'subsidiarySaveorEdit'])->name('reports.subsidiarySaveorEdit');
Route::get('reports/reportPrint', [ReportsController::class, 'reportPrint'])->name('reports.reportPrint');
Route::post('reports/bank-reconciliation', [ReportsController::class,'bankReconciliation'])->name('reports.bank.reconciliation');

Route::post('collections',[CollectionController::class, 'store'])->name('create.collection.breakdown');
Route::delete('collections/{collection}',[CollectionController::class, 'destroy'])->name('delete.collection');

Route::post('reports/cashTransactionBlotter/storecashblotter', [ReportsController::class, 'storeCashBlotter'])->name('reports.storeCashBlotter');
/* Route::get('reports/cashTransactionBlotter/showcashblotter/{id}', [ReportsController::class, 'showCashBlotter'])->name('reports.showCashBlotter'); */
/* Route::get('reports/cashTransactionBlotter/editcashblotter/{id}', [ReportsController::class, 'editCashBlotter'])->name('reports.editCashBlotter'); */
Route::get('reports/cashTransactionBlotter/geteditcashblotter/{id}', [ReportsController::class, 'getEditCashBlotter'])->name('reports.getEditCashBlotter');
Route::get('reports/cashTransactionBlotter/fetchaccountofficer/{id}', [ReportsController::class, 'fetchAccountOfficer'])->name('reports.fetchAccountOfficer');
/* Route::post('reports/revenue-minus-expense', [ReportsController::class, 'revenueMinusExpense'])->name('revenue-minus-expenses'); */


Route::get('payment/create/{id}', [PaymentController::class, 'create'])->name('payment.create');
Route::get('payment/customer/{id}', [PaymentController::class, 'customerPayment'])->name('payment.customer');
// Route::get('payment/invoice', [PaymentController::class, ''])->name('');
// Route::get('payment/supplier', [PaymentController::class, ''])->name('');
// Route::get('payment/bill', [PaymentController::class, ''])->name('');
Route::post('payment/store', [PaymentController::class, 'store'])->name('payment.store');

// journal
Route::get('journal', [JournalController::class, 'create'])->name('journal.create');
Route::post('journal', [JournalController::class, 'store'])->name('journal.store');
Route::get('journal/journalEntry', [JournalController::class, 'journalEntry'])->name('journal.journalEntry');
Route::get('journal/journalEntryList', [JournalController::class, 'journalEntryList'])->name('journal.journalEntryList');
Route::post('journal/saveJournalEntry', [JournalController::class, 'saveJournalEntry'])->name('journal.saveJournalEntry');
Route::post('journal/saveJournalEntryDetails', [JournalController::class, 'saveJournalEntryDetails'])->name('journal.saveJournalEntryDetails');
Route::post('journal/JournalEntryFetch', [JournalController::class, 'JournalEntryFetch'])->name('journal.JournalEntryFetch');
Route::post('journal/JournalEntryDelete', [JournalController::class, 'JournalEntryDelete'])->name('journal.JournalEntryDelete');
Route::post('journal/JournalEntryEdit', [JournalController::class, 'JournalEntryEdit'])->name('journal.JournalEntryEdit');
Route::post('journal/JournalEntryPostUnpost', [JournalController::class, 'JournalEntryPostUnpost'])->name('journal.JournalEntryPostUnpost');
Route::get('journal/searchJournalEntry', [JournalController::class, 'searchJournalEntry'])->name('journal.searchJournalEntry');

// User Profile
Route::get('user/profile', [UserProfileController::class, 'index'])->name('user.profile');
Route::post('user/profile/username/update', [UserProfileController::class, 'updateUsername'])->name('username.update');
Route::post('user/profile/password/update', [UserProfileController::class, 'updatePassword'])->name('password.update');
