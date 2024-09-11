<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\Installment;
use App\Http\Resources\Installment\InstallmentSupplierResource;
use App\Traits\InstallmentTrait;

class InstallmentSupplierController extends Controller  implements HasMiddleware
{
  use InstallmentTrait;

  public static function middleware(): array
  {
    return [
      'permission:installments',
    ];
  }
  /**
   * Display a listing of the resource.
   */

  public function index()
  {
    $installments = Installment::with(['payments', 'materials', 'supplier'])->where('type', 'supplier')->paginate(10);

    return InstallmentSupplierResource::collection($installments);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'client_id' => ['required', 'integer', 'exists:suppliers,id'],
      'installment_amount' => ['required', 'integer'],
      'attachment' => ["required", 'file', 'max:10240', 'mimes:png,jpg,pdf,docx'],
      'start' => ['required', 'date'],
      'duration' => ['required', 'in:week,month,year'],
      'products' => ['required', 'array'],
      'products.*' => ['array'],
      'products.*.id' => ['integer', 'exists:raw_materials,id'],
      'products.*.quantity' => ['integer']
    ]);


    if (!$validator->fails()) {
      // Get the validated data
      $validatedData = $validator->validated();
      $validatedData['type'] = 'supplier';
      return  $this->storeInstallment($request, $validatedData, "supplier");
    } else {
      return response()->json([
        "errors" => $validator->errors()
      ], 400);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $installment = Installment::with(["payments", "materials"])->where('type', 'supplier')->findOrFail($id);
    return response()->json(new InstallmentSupplierResource($installment));
  }
}
