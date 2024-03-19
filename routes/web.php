<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductCartItemsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\DashboardController;
use \App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ConfigController;
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


Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/users', [CustomerController::class, 'getUsers'])->name('admin.users');
        Route::get('/user/vendors', [CustomerController::class, 'getVendors'])->name('admin.vendors');
        Route::controller(ProductController::class)->group(function () {
            Route::get('/products','index')->name('products');
            Route::any('/product/upload','actionUpload')->name('product.upload');
            Route::get('/ajax/product','getProduct')->name('ajax.product');
            Route::get('/ajax/products','getProducts')->name('ajax.products');
            Route::get('/delete/product/{product}','deleteProduct')->name('delete.product');
            Route::get('/product/create','create')->name('create.product');
            Route::post('/product/store','store')->name('store.product');
            Route::get('/edit/product/{id_product}','edit')->name('edit.product');
            Route::post('/product/update','update')->name('update.product');
            Route::get('/ajax/product/delete-image','deleteProductImage')->name('ajax.deleteProductImage');
            // Accessories
            Route::get('/accessories','getAccessories')->name('accessories');
            Route::get('/accessories/create','createAccessories')->name('create.accessories');
            Route::get('/edit/accessories/{id_accessory}','editAccessory')->name('edit.accessory');
            Route::get('/delete/accessories/{id_accessory}','deleteProduct')->name('delete.accessory');
            Route::get('/ajax/accessories','getAccessories')->name('ajax.accessories');
            Route::post('/ajax/accessories/charge', 'updateAccessoriesPaymentStatus')->name('quote.updateAccessoriesPaymentStatus');
        });
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/customers','getCustomers')->name('customers');
            Route::get('/add/customer','add')->name('create.customer');
            Route::post('/store/customer','updateCustomerForm')->name('store.customer');
            Route::get('/ajax/customers','getCustomers')->name('ajax.customers');
            Route::get('/edit/customer/{user}','edit')->name('edit.customer');
            Route::get('/delete/customer/{user}','deleteCustomer')->name('delete.customer');
            Route::post('/customer/change-password','changePassword')->name('customer.changePassword');
        });
        Route::controller(RolesController::class)->group(function () {
            Route::get('/roles','index')->name('roles');
            Route::get('/delete/role/{role}','deleteRole')->name('delete.role');
            Route::get('/edit/role/{role}','edit')->name('edit.role');
            Route::get('/role/create','create')->name('create.role');
            Route::post('/role/store','store')->name('store.role');
            Route::post('/role/update','update')->name('update.role');
        });
        Route::controller(ConfigController::class)->group(function () {
            Route::get('/configs','index')->name('configs');
            Route::get('/delete/config/{config}','destroy')->name('delete.config');
            Route::get('/edit/config/{config}','edit')->name('edit.config');
            Route::get('/config/create','create')->name('create.config');
            Route::post('/config/store','store')->name('store.config');
            Route::post('/config/update','update')->name('update.config');
        });
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories','index')->name('categories');
            Route::get('/category/create','create')->name('create.category');
            Route::post('/category/store','store')->name('store.category');
            Route::get('/category/delete/{category}','destroy')->name('delete.category');
            Route::get('/category/edit/{category}','edit')->name('edit.category');
            Route::post('/category/update','update')->name('update.category');
        });
    });
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });
    Route::controller(QuoteController::class)->group(function () {
        Route::get('/quotes', 'index')->name('quotes');
        Route::get('/ajax/quotes', 'index')->name('ajax.quotes');
        Route::post('/quote/details', 'getQuote')->name('ajax.getQuote');
        Route::get('/quote/create', 'create')->name('quote.add');
        Route::post('/quote/add', 'store')->name('quote.create');
        Route::post('/quote/update/{quote}', 'update')->name('quote.update');
        Route::get('/quote/edit/{id}', 'edit')->name('quote.edit');
        Route::get('/quote/delete/{id}', 'destroy')->name('quote.delete');
        Route::get('/quote/downloadQuote/{quote_id}', 'downloadQuote')->name('quote.download');
        Route::post('/quote/change-status/{quote_id}', 'changeStatus')->name('quote.changeStatus');
        Route::get('/quote/send-quote', 'sendQuote')->name('quote.sendQuote');
        Route::post('/ajax/update-terms-n-conditions', 'updateTermCondition')->name('quote.updateTermCondition');
        Route::get('/ajax/getInstallationCharge', 'getInstallationCharge')->name('quote.getInstallationCharge');
        Route::get('/ajax/getFreightCharge', 'getFreightCharge')->name('quote.getFreightCharge');
    });
    Route::controller(ProductCartItemsController::class)->group(function(){
        Route::post('/product/additem','addCartItem')->name('product.additem');
        Route::get('/quote/items/{id}','getItems')->name('getItems');
        Route::get('/remove/item','removeCartItem')->name('item.remove');
        Route::post('/apply-discount','applyDiscount')->name('applyDiscount');
        Route::get('/remove-discount/{quote_id}','removeDiscount')->name('removeDiscount');
    });
    Route::controller(InvoiceController::class)->group(function(){
        Route::get('/invoices','index')->name('invoices');
        Route::get('/invoice/create','create')->name('create.invoice');
        Route::post('/invoice/store','store')->name('store.invoice');
        Route::get('/invoice/edit/{invoice_id}','edit')->name('edit.invoice');
        Route::post('/invoice/update','update')->name('update.invoice');
        Route::get('/invoice/delete/{invoice}','destroy')->name('delete.invoice');
        Route::get('/invoice/download/{invoice_id}', 'downloadInvoice')->name('invoice.download');
    });
    Route::controller(PurchaseOrderController::class)->group(function(){
        Route::get('/purchase-orders','index')->name('purchase.orders');
        Route::get('/purchase-order/create','create')->name('create.purchase-order');
        Route::post('/purchase-order/store','store')->name('store.purchaseOrder');
        Route::get('/purchase-order/delete','destroy')->name('delete.purchaseOrder');
        Route::get('/purchase-order/edit/{purchaseOrderId}','edit')->name('edit.purchaseOrder');
        Route::post('/purchase-order/update/{purchaseOrder}','update')->name('update.purchaseOrder');
        Route::post('/purchase-order/details','getPurchseOrder')->name('po.getPurchseOrder');
        Route::get('/purchase-order/download/{po_id}', 'downloadPurchaseOrder')->name('po.download');
    });
});

Route::post('/user/details', [App\Http\Controllers\HomeController::class, 'getUser'])->name('users');
Route::get('/user/info', [App\Http\Controllers\HomeController::class, 'getUserDetails'])->name('user.info');
//Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/download', [App\Http\Controllers\HomeController::class, 'download'])->name('download');

Route::get('/email', [App\Http\Controllers\HomeController::class, 'sendTestEmail'])->name('sendTestEmail');


Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('your_receiver_email@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});
Route::get('/category-product', [\App\Http\Controllers\Api\GeneralController::class, 'index']);
