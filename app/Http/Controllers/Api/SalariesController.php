<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Traits\TransactionTrait;
use App\Http\Resources\SalaryResource;

class SalariesController extends Controller
{
  use TransactionTrait;

  protected function rules()
  {
    return [
      'employee_id' => ['required', 'exists:users,id'],
      'amount' => ['required', 'integer'],
      'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc', 'max:2048'],
      'description' => ['nullable', 'string', 'min:3'],
    ];
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $salaries = Salary::with('user')->orderBy('id', 'desc')->paginate(10);
    return response()->json(SalaryResource::collection($salaries), 200);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules());
    if (!$validator->fails()) {
      try {
        $validatorData = $validator->valid();
        $validatorData['owner_id'] = auth()->user()->id;
        if ($request->hasFile('attachment')) {
          $filename = $request->attachment->hashName();
          $validatorData['attachment'] = $filename;
          $request->file("attachment")->storeAs("salaries/employees", $filename);
        }

        $user = User::findOrFail($request->employee_id);
        $user->sallaries()->create($validatorData);
        $user->update([
          'wallet' => $user->wallet -  $validatorData['amount'],
        ]);

        // create transaction
        $request['transaction_category'] = 'salary';
        $request['transaction_type'] = 'withdraw';
        $request['client_id'] = $user->id;
        $request['client_type'] = 'employee';
        $this->storeTransaction($request);

        return response()->json(['message' => 'Salary created successfully'], 201);
      } catch (\Exception $e) {
        return response()->json([
          'errors' => $validator->errors()
        ], 400);
      }
    } else {
      return response()->json([
        'errors' => $validator->errors()
      ], 400);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $salary = Salary::with('user')->findOrFail($id);
    return response()->json(new SalaryResource($salary));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      Salary::findOrFail($id)->delete();
      return response()->json(['message' => 'This Salary has been successfully delete'], 202);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}
