<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairController extends Controller
{
    
    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'price'               => ['integer', 'required'],
            'date'                => ['date', 'required'],
            'problem_reason'      => ['string', 'required', 'min:5', 'max:255'],
            'what_has_been_fixed' => ['string', 'required', 'min:5', 'max:255'],
            'machine_id'          => ['required', 'integer', 'exists:machines,id']
          ]);
      
          if ($validate->fails()) {
            return response()->json([
              'errors' => $validate->errors()
            ], 400);
          }

          Repair::create([
            'price'               => $request->price,
            'date'                => $request->date,
            'problem_reason'      => $request->problem_reason,
            'what_has_been_fixed' => $request->what_has_been_fixed,
            'machine_id'          => $request->machine_id
          ]);

          return response([
            'Message' => 'Suc'
          ]);

    }

    public function update(Request $request, $id) {

        $validate = Validator::make($request->all(), [
            'price'               => ['integer', 'required'],
            'date'                => ['date', 'required'],
            'problem_reason'      => ['string', 'required', 'min:5', 'max:255'],
            'what_has_been_fixed' => ['string', 'required', 'min:5', 'max:255'],
            'machine_id'          => ['required', 'integer', 'exists:machines,id']
          ]);
      
          if ($validate->fails()) {
            return response()->json([
              'errors' => $validate->errors()
            ], 400);
          }

          Repair::findOrFail($id)->update([
            'price'               => $request->price,
            'date'                => $request->date,
            'problem_reason'      => $request->problem_reason,
            'what_has_been_fixed' => $request->what_has_been_fixed,
            'machine_id'          => $request->machine_id
          ]);

          return response([
            'Message' => 'Suc'
          ]);

    }

    public function delete($id) {

        Repair::findOrFail($id)->delete();
        return response([
          'Message' => 'Suc'
        ]);
        
    }

}
