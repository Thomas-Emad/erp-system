<?php

namespace App\Http\Controllers;

use App\Models\Rival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RivalController extends Controller
{
    
    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'rival_value'     => ['required', 'integer'],
            'reason_for_rival' => ['required', 'string', 'max:255'],
            'employee_id'     => ['required', 'integer']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $rival = Rival::create([
            'rival_value'     => $request->rival_value,
            'reason_for_rival' => $request->reason_for_rival,
            'employee_id'     => $request->employee_id
        ]);

        // بنقص من رصيد الموظف القيمة اللي اتخصمت
        $rival->employee->update([
            'wallet' => $rival->employee->wallet - $rival->rival_value
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

    public function update(Request $request, $rival_id) {

        $validate = Validator::make($request->all(), [
            'rival_value'     => ['required', 'integer'],
            'reason_for_rival' => ['required', 'string', 'max:255'],
            'employee_id'     => ['required', 'integer']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $rival = Rival::findOrFail($rival_id);

        // بزود القيمة اللي اتخصمت لهذا الموظف بالخطأ
        $rival->employee->update([
            'wallet' => $rival->employee->wallet + $rival->rival_value
        ]);
        
        $rival->update([
            'rival_value'     => $request->rival_value,
            'reason_for_rival' => $request->reason_for_rival,
            'employee_id'     => $request->employee_id
        ]);

        // بنقص من رصيد الموظف القيمة اللي اتخصمت
        $rival->employee->update([
            'wallet' => $rival->employee->wallet - $rival->rival_value
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

    public function destroy($rival_id) {

        $rival = Rival::findOrFail($rival_id);

        // بزود القيمة اللي اتخصمت لهذا الموظف بالخطأ
        $rival->employee->update([
            'wallet' => $rival->employee->wallet + $rival->rival_value
        ]);

        $rival->delete();

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

}
