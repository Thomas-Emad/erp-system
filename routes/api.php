<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
  AuthController,
  RoleController,
  FactoryController,
  StoreController,
  CustomerController,
  HolidayController,
  SupplierController,
  VacationController,
  AttendanceController,
  InstallmentSupplierController,
  InstallmentCustomerController,
  TransactionController,
  SalariesController
};
use App\Http\Controllers\{
  ProductController,
  MachineController,
  RawMaterialController,
  RivalController,
  RewardController,
  SellingInvoiceController,
  BuyingInvoiceController,
};


// User Auth
Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
  Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'JwtAuth'], function () {

  // User Auth
  Route::group(['prefix' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::patch('/updateByAdmin/{id}', [AuthController::class, 'updateByAdmin']);
  });

  // Roles
  Route::apiResource('/roles', RoleController::class);
  Route::get('/role/getAllPremission', [RoleController::class, 'getAllPremission']);

  // Factories
  Route::apiResource('/factories', FactoryController::class);

  // Stores
  Route::apiResource('/stores', StoreController::class);

  // Product Controller
  Route::group(['prefix' => 'products'], function () {
    Route::get('/index', [ProductController::class, 'index']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::put('/update/{id}', [ProductController::class, 'update']);
    Route::get('/show/{id}', [ProductController::class, 'show']);
    Route::get('/destroy', [ProductController::class, 'destroy']);
  });

  // Machine Controller
  Route::group(['prefix' => 'machines'], function () {
    Route::get('/index', [MachineController::class, 'index']);
    Route::get('/show/{id}', [MachineController::class, 'show']);
    Route::post('/store', [MachineController::class, 'store']);
    Route::put('/update/{id}', [MachineController::class, 'update']);
    Route::get('/destroy', [MachineController::class, 'destroy']);
  });

  // Raw Material Controller
  Route::group(['prefix' => 'rawmaterial'], function () {
    Route::get('/index', [RawMaterialController::class, 'index']);
    Route::get('/show/{id}', [RawMaterialController::class, 'show']);
    Route::post('/store', [RawMaterialController::class, 'store']);
    Route::put('/update/{id}', [RawMaterialController::class, 'update']);
    Route::get('/destroy', [RawMaterialController::class, 'destroy']);
  });

  // Rivals Controller
  Route::group(['prefix' => 'rivals'], function () {
    Route::post('/store', [RivalController::class, 'store']);
    Route::put('/update/{id}', [RivalController::class, 'update']);
    Route::get('/destroy/{id}', [RivalController::class, 'destroy']);
  });

  // Reward Controller
  Route::group(['prefix' => 'rewards'], function () {
    Route::post('/store', [RewardController::class, 'store']);
    Route::put('/update/{id}', [RewardController::class, 'update']);
    Route::get('/destroy/{id}', [RewardController::class, 'destroy']);
  });

  // Customers
  Route::apiResource('/customers', CustomerController::class);

  //  Supplier
  Route::apiResource('/suppliers', SupplierController::class);

  // holidays
  Route::apiResource('/holidays', HolidayController::class);

  // Vacation
  Route::apiResource('/vacations', VacationController::class);

  // attendaces
  Route::group(['controller' => AttendanceController::class], function () {
    Route::get('/attendaces', 'index');
    Route::post('/attendaces', 'store');
  });

  // Buying Invoice
  Route::group(['prefix' => 'BuyingInvoice'], function () {
    Route::post('/create', [BuyingInvoiceController::class, 'CreateBuyingInvoice']);
    Route::put('/AddRawMaterial/{buying_invoice_id}', [BuyingInvoiceController::class, 'AddRawMaterialInInvoice']);
    Route::put('/Delete/{buying_invoice_raw_material_id}', [BuyingInvoiceController::class, 'DeleteRawMaterialFromBuyingInvoice']);
  });

  // Selling Invoice
  Route::group(['prefix' => 'SellingInvoice'], function () {
    Route::post('/create', [SellingInvoiceController::class, 'CreateSellingInvoice']);
    Route::put('/AddProduct/{selling_invoice_id}', [SellingInvoiceController::class, 'AddProductInInvoice']);
    Route::put('/Delete/{selling_invoice_product_id}', [SellingInvoiceController::class, 'DeleteProductFromSellingInvoice']);
  });

  // Installment Suppliers
  Route::apiResource('/installment_suppliers', InstallmentSupplierController::class);
  Route::post('/installment_suppliers/paid', [InstallmentSupplierController::class, 'paidPaymentInstallment']);

  // Installment Customer
  Route::apiResource('/installment_customers', InstallmentCustomerController::class);
  Route::post('/installment_customers/paid', [InstallmentCustomerController::class, 'paidPaymentInstallment']);

  // Transaction Controller
  Route::apiResource('/transactions', TransactionController::class);
  Route::apiResource('/salaries', SalariesController::class);
});
