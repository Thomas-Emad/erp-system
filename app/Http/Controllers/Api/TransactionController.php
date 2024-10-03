<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransactionResource;
use App\Traits\TransactionTrait;

class TransactionController extends Controller
{
  use TransactionTrait;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $transactions = Transaction::with(['user', 'customer', 'supplier'])->paginate(10);
    return response()->json(TransactionResource::collection($transactions), 200);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    return  $this->storeTransaction($request);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $transaction = Transaction::with(['user', 'customer', 'supplier'])->findOrFail($id);
    return response()->json(TransactionResource::make($transaction), 202);
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
      Transaction::findOrFail($id)->delete();
      return response()->json(['message' => 'This Transaction has been successfully delete'], 202);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}
