<?php

use Illuminate\Support\Facades\Route;
// npm install && npm run dev
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCafeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransCafeController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OperationalController;
use App\Http\Controllers\CostOpController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ReportController;

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

Route::get('/test', function () {
    return view('web.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [DashboardController::class, 'index']);

    // Product routes
    Route::get('/master/products', [ProductController::class, 'index']);
    Route::get('/', [DashboardController::class, 'index']);

    // Product routes
    Route::get('/master/products', [ProductController::class, 'index']);
    Route::get('/product/ajaxproduct', [ProductController::class, 'ajaxProduct']);
    Route::get('/product/add', [ProductController::class, 'addNew']);
    Route::post('/product/addpost', [ProductController::class, 'addPost']);
    Route::get('/product/edit-{id}', [ProductController::class, 'edit']);
    Route::post('/product/editpost', [ProductController::class, 'EditPost']);

    // Product Cafe Routes
    Route::get('/master/productcafe', [ProductCafeController::class, 'index']);
    Route::get('/data/productcafe', [ProductCafeController::class, 'index']);
    Route::get('/productcafe/add', function() {
        return view('productcafe.add');
    });
    Route::post('/productcafe/addpost', [ProductCafeController::class, 'addPost']);
    Route::get('/productcafe/edit/{id}', [ProductCafeController::class, 'edit']);
    Route::post('/productcafe/editpost', [ProductCafeController::class, 'editPost']);
    Route::get('/productcafe/printlist', [ProductCafeController::class, 'PrintList']);

    // User Routes
    Route::get('/master/user/all', [UserController::class, 'index']);
    Route::get('/user/changepassword-{id}', [UserController::class, 'changeGet']);
    Route::post('/user/changepass', [UserController::class, 'ChangePass']);
    Route::get('/user/edit/{id}', [UserController::class, 'Edit']);
    Route::post('/user/editpost', [UserController::class, 'EditPost']);
    Route::get('/user/add', [UserController::class, 'AddNew']);
    Route::post('/user/addpost', [UserController::class, 'AddPost']);

    // Service Routes
    Route::get('/master/services', [ServiceController::class, 'index']);
    Route::get('/service/ajaxservice', [ServiceController::class, 'ajaxService']);
    Route::get('/service/add', [ServiceController::class, 'addNew']);
    Route::post('/service/addpost', [ServiceController::class, 'addPost']);
    Route::get('/service/edit-{id}', [ServiceController::class, 'edit']);
    Route::post('/service/editpost', [ServiceController::class, 'editPost']);

    //Customer Routes
    Route::get('/data/customer/all', [CustomerController::class, 'index']);
    Route::get('/customer/add', [CustomerController::class, 'addNew']);
    Route::post('/customer/addpost', [CustomerController::class, 'addPost']);
    Route::get('/customer/edit-{id}', [CustomerController::class, 'edit']);
    Route::post('/customer/editpost', [CustomerController::class, 'EditPost']);
    Route::get('/customer/getvisit/{id}', [CustomerController::class, 'GetVisit']);
    Route::get('/customer/getorder', [CustomerController::class, 'GetOrder']);
    Route::post('/customer/addorder', [CustomerController::class, 'AddAndOrder']);
    Route::get('/customer/getajaxindex', [CustomerController::class, 'CustomerAjax']);

    //Barberman Routes
    Route::get('/master/barberman/all', [BarberController::class, 'index']);
    Route::get('/barberman/add', [BarberController::class, 'addNew']);
    Route::post('/barberman/addpost', [BarberController::class, 'addPost']);
    Route::get('/barberman/edit-{id}', [BarberController::class, 'edit']);
    Route::post('/barberman/editpost', [BarberController::class, 'editPost']);
    Route::post('/barberman/addservice', [BarberController::class, 'servicePost']);
    Route::get('/barberman/serviceajax-{id}', [BarberController::class, 'serviceajax']);
    Route::get('/barberman/delserv-{id}', [BarberController::class, 'deleteService']);
    Route::get('/barberman/editservice/{id}', [BarberController::class, 'EditService']);
    Route::post('/barberman/editservpost', [BarberController::class, 'EditServicePost']);

    // Transaction Routes
    Route::post('/transaction/new', [TransactionController::class, 'NewTransaction']);
    Route::get('/transaction/index', [TransactionController::class, 'index']);
    Route::get('/transaction/cashier', [TransactionController::class, 'CashierIndex']);
    Route::get('/transaction/ajaxdata', [TransactionController::class, 'ajaxTrx']);
    Route::post('/transaction/addtransbbdetail', [TransactionController::class, 'addBbDetail']);
    Route::get('/transaction/ajaxtransbbdetail-{id}', [TransactionController::class, 'ajaxTransbbdetail']);
    Route::get('/transaction/gettotal-{id}', [TransactionController::class, 'getTotalTrx']);
    Route::get('/transaction/deltransdetail-{id}', [TransactionController::class, 'DeleteDetails']);
    Route::get('/transaction/getcheckout-{id}', [TransactionController::class, 'GetCheckout']);
    Route::post('/transaction/checkout', [TransactionController::class, 'FinalizeCheckout']);
    Route::get('/transaction/printpreview-{id}', [TransactionController::class, 'PrintPreview']);
    Route::get('/transaction/struk/{id}', [TransactionController::class, 'PrintStruk']);
    Route::get('/transaction/ajaxtransbbproduct-{id}', [TransactionController::class, 'ajaxTransProduct']);
    Route::post('/transaction/addtransbbproduct', [TransactionController::class, 'addBBProduct']);
    Route::get('/transaction/deltransproduct-{id}', [TransactionController::class, 'DeleteProducts']);
    Route::get('/transaction/ajaxdetails/{id}', [TransactionController::class, 'ajaxdetails']);
    Route::get('/transaction/getcustomertrans/{id}', [TransactionController::class, 'GetCustomerTrans']);
    Route::get('/transaction/getcustomerajax/{id}', [TransactionController::class, 'GetCustomerAjax']);
    Route::post('/transaction/newfromtable/{id}', [TransactionController::class, 'TransNewFromTable']);
    Route::get('/transaction/invoice/reprint', function() {
        return view('transaction.reprint');
    });
    Route::get('/transaction/ajaxreprint', [TransactionController::class, 'AjaxReprint']);

    //Transaction Cafe
    Route::get('/transaction/cafe', [TransCafeController::class, 'index']);
    Route::get('/transaction/cafe/getdata', [TransCafeController::class, 'GetData']);
    Route::post('/transaction/cafe/addsubtrans', [TransCafeController::class, 'AddSubTrans']);
    Route::get('/transaction/cafe/totalcart', [TransCafeController::class, 'GetTotalCart']);
    Route::post('/transaction/cafe/clearcart', [TransCafeController::class, 'ClearCart']);
    Route::post('/transaction/cafe/newtrans', [TransCafeController::class, 'ClearCart']);
    Route::get('/transaction/cafe/delsub/{id}', [TransCafeController::class, 'DelSub']);
    Route::get('/transaction/cafe/getcheckout', [TransCafeController::class, 'GetCheckOut']);
    Route::post('/transaction/cafe/checkout', [TransCafeController::class, 'CheckOut']);
    Route::get('/transaction/cafe/print', [TransCafeController::class, 'PrintStruk']);

    // Discounts Routes
    Route::get('/master/discounts', [DiscountController::class, 'index']);
    Route::get('/discounts/ajaxdata', [DiscountController::class, 'ajaxDiscounts']);
    Route::get('/discounts/add', [DiscountController::class, 'GetNew']);
    Route::post('/discounts/addpost', [DiscountController::class, 'AddPost']);
    Route::get('/discounts/edit/{id}', [DiscountController::class, 'EditGet']);
    Route::post('/discounts/editpost', [DiscountController::class, 'EditPost']);
    Route::get('/discounts/check/{id}', [DiscountController::class, 'CheckID']);
    Route::get('/data/discounts', [DiscountController::class, 'index']);
    Route::get('/discounts/multiple', [DiscountController::class, 'AddBulk']);
    Route::post('/discounts/addbulk', [DiscountController::class, 'AddBulkPost']);

    // operational Routes
    Route::get('/master/operational', [OperationalController::class, 'index']);
    Route::get('/operational/ajaxdata', [OperationalController::class, 'ajaxOperationals']);
    Route::get('/operational/add', [OperationalController::class, 'GetNew']);
    Route::post('/operational/addpost', [OperationalController::class, 'AddPost']);
    Route::get('/operational/edit/{id}', [OperationalController::class, 'EditGet']);
    Route::post('/operational/editpost', [OperationalController::class, 'EditPost']);

    // cost_op Routes
    Route::get('/cost_op', [CostOpController::class, 'index']);
    Route::get('/cost_op/ajaxdata', [CostOpController::class, 'ajaxcost_ops']);
    Route::get('/cost_op/add', [CostOpController::class, 'GetNew']);
    Route::post('/cost_op/addpost', [CostOpController::class, 'AddPost']);
    Route::get('/cost_op/edit/{id}', [CostOpController::class, 'EditGet']);
    Route::post('/cost_op/editpost', [CostOpController::class, 'EditPost']);

    // Vouchers Routes
    Route::get('/master/vouchers', [VoucherController::class, 'index']);
    Route::get('/vouchers/ajaxdata', [VoucherController::class, 'ajaxVouchers']);
    Route::get('/vouchers/add', [VoucherController::class, 'GetNew']);
    Route::post('/vouchers/addpost', [VoucherController::class, 'AddPost']);
    Route::get('/vouchers/edit/{id}', [VoucherController::class, 'EditGet']);
    Route::post('/vouchers/editpost', [VoucherController::class, 'EditPost']);
    Route::get('/vouchers/check/{id}', [VoucherController::class, 'CheckID']);
    Route::get('/data/vouchers', [VoucherController::class, 'index']);
    Route::get('/vouchers/multiple', [VoucherController::class, 'AddBulk']);
    Route::post('/vouchers/addbulk', [VoucherController::class, 'AddBulkPost']);

    // Notes Controllers
    Route::get('/master/notes', [NoteController::class, 'index']);
    Route::get('/notes/ajaxdata', [NoteController::class, 'ajaxData']);
    Route::get('/notes/add', [NoteController::class, 'AddNew']);
    Route::post('/notes/addpost', [NoteController::class, 'AddPost']);
    Route::get('/notes/edit/{id}', [NoteController::class, 'EditGet']);
    Route::post('/notes/editpost', [NoteController::class, 'EditPost']);
    Route::get('/notes/activate/{id}', [NoteController::class, 'Activate']);

    //Report Routes
    Route::get('/reports/lapbbman', [ReportController::class, 'LapBBMan']);
    Route::get('/reports/lapbbman/{tglawal}/{tglakhir}/{id}', [ReportController::class, 'PrintLapBBMan']);
    Route::get('/reports/recap', [ReportController::class, 'RecapIndex']);
    Route::get('/reports/laprecap/{tglawal}/{tglakhir}', [ReportController::class, 'PrintRecap']);
    Route::get('/reports/bbdetailsindex', [ReportController::class, 'DetailBBIndex']);
    Route::get('/reports/bbdetails/{tglawal}/{tglakhir}', [ReportController::class, 'DetailBB']);
    Route::get('/reports/cashier/lapbbman/{tglawal}/{tglakhir}/{id}', [ReportController::class, 'CashierPrintLapBBDaily']);

    Route:: get('/reports/master', function() {
        return view('reports.master');
    });
    //biaya pengeluaran
    Route::get('/reports/ajaxpengeluaran/{tglawal}/{tglakhir}', [ReportController::class, 'ajaxCostReport']);
    Route::get('/reports/getsumcost/{tglawal}/{tglakhir}', [ReportController::class, 'GetSumCost']);

    Route::get('/reports/ajaxmaster/{tglawal}/{tglakhir}', [ReportController::class, 'ajaxTransReport']);
    Route::get('/reports/getsum/{tglawal}/{tglakhir}', [ReportController::class, 'GetSum']);
    Route::get('/reports/ajaxpivottrans/{tglawal}/{tglakhir}', [ReportController::class, 'AjaxPivotTrans']);
    Route::get('/data/reports/lapbbman', [ReportController::class, 'CashierLapBbmanIndex']);
    Route::get('/reports/cafe', [ReportController::class, 'CafeIndex']);
    Route::get('/reports/cafe/ajaxcafe/{tglawal}/{tglakhir}', [ReportController::class, 'AjaxCafe']);
    Route::get('/reports/cafe/getsum/{tglawal}/{tglakhir}', [ReportController::class, 'GetSumCafe']);
    Route::get('/reports/cafe/cafepivottrans/{tglawal}/{tglakhir}', [ReportController::class, 'CafePivotTrans']);
    Route::get('/reports/bbsexcel/{tglawal}/{tglakhir}', [ReportController::class, 'DownloadExcelBbs']);
    Route::get('/reports/bbspdf/{tglawal}/{tglakhir}', [ReportController::class, 'DownloadPdfBbs']);
    Route::get('/reports/cafe/exportexcel/{tglawal}/{tglakhir}', [ReportController::class, 'DownloadExcelCafe']);
    Route::get('/reports/cafe/exportpdf/{tglawal}/{tglakhir}', [ReportController::class, 'DownloadPdfCafe']);
    Route::get('/reports/lapbbmanager/{tglawal}/{tglakhir}/{id}', [ReportController::class, 'LapBBManager']);
    Route::get('/reports/printlaptrans/{tglawal}/{tglakhir}', [ReportController::class, 'PrintLapTrans']);
    Route::get('/reports/cafe/printlaptrans/{tglawal}/{tglakhir}', [ReportController::class, 'PrintLapCafe']);
    //report
    Route::get('/report', [ReportController::class, 'index']);
    Route::get('/report/excel/{tAwal}/{tAkhir}', [ReportController::class, 'ExcelBulanan']);

});
