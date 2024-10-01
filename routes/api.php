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
  InstallmentSupplierController,
  InstallmentCustomerController,
  TransactionController,
  SalariesController,
  ReportsController
};

use App\Http\Controllers\{
  ProductController,
  MachineController,
  RawMaterialController,
  RivalController,
  RewardController,
  SellingInvoiceController,
  BuyingInvoiceController,
  TaskController,
  AttendanceController,
  OrderController,
  VacationRequestController,
  SwitchController,
  RepairController,
  BuyingReturnController,
  SellingReturnController
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
  Route::group(['prefix' => 'rawmaterials'], function () {
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

  // Order Invoice
  Route::group(['prefix' => 'orders'], function () {
    Route::post('/create', [OrderController::class, 'CraeteOrder']);
    Route::put('/AddProduct/{order_id}', [OrderController::class, 'AddProductInOreder']);
    Route::put('/edit/{order_id}', [OrderController::class, 'DeliveryOfTheOrder']);
  });

  // Switchs Invoice
  Route::group(['prefix' => 'switchs'], function () {
    Route::post('/store', [SwitchController::class, 'SwitchBetweenStore']);
    Route::post('/factory', [SwitchController::class, 'SwitchBetweenFactory']);
  });

  // vacation request Invoice
  Route::group(['prefix' => 'vacation_request'], function () {
    Route::post('/store', [VacationRequestController::class, 'store']);
    Route::put('/update/{id}', [VacationRequestController::class, 'update']);
    Route::delete('/delete/{id}', [VacationRequestController::class, 'delete']);
  });

  // Tasks Invoice
  Route::group(['prefix' => 'tasks'], function () {
    Route::post('/store', [TaskController::class, 'store']);
    Route::put('/update/{id}', [TaskController::class, 'update']);
    Route::put('/add_employee/{id}', [TaskController::class, 'add_employee_for_task']);
    Route::put('/modify_by_admin/{id}', [TaskController::class, 'modify_status_by_admin']);
    Route::put('/modify_by_manager/{id}', [TaskController::class, 'modify_status_by_manager']);
  });

  // Attendants Invoice
  Route::group(['prefix' => 'attendance'], function () {
    Route::post('/store', [AttendanceController::class, 'store']);
  });

  // Repairs
  Route::group(['prefix' => 'repairs'], function () {
    Route::post('/store', [RepairController::class, 'store']);
    Route::put('/update/{id}', [RepairController::class, 'update']);
    Route::delete('/delete/{id}', [RepairController::class, 'delete']);
  });

  // Selling Return
  Route::group(['prefix' => 'selling_return'], function () {
    Route::put('/return/{id}', [SellingReturnController::class, 'return']);
  });

  // Buying Return
  Route::group(['prefix' => 'buying_return'], function () {
    Route::put('/return/{id}', [BuyingReturnController::class, 'return']);
  });

  // Reports
  Route::group(['prefix' => 'reports'], function () {
    Route::get('/top-product', [ReportsController::class, 'topProductsByProfit']);
    Route::get('/key_matrics', [ReportsController::class, 'report']);
    Route::get('/report_details', [ReportsController::class, 'report_details']);
    Route::get('/purchase-sale', [ReportsController::class, 'purchaseSale']);
  });
});
