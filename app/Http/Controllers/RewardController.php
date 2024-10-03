<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RewardController extends Controller
{

    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'reward_value'     => ['required', 'integer'],
            'reason_for_reward' => ['required', 'string', 'max:255'],
            'employee_id'      => ['required', 'integer']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $reward = Reward::create([
            'reward_value'     => $request->reward_value,
            'reason_for_reward' => $request->reason_for_reward,
            'employee_id'      => $request->employee_id
        ]);

        // بزود على رصيد الموظف الحافز اللي خده
        $reward->employee->update([
            'wallet' => $reward->employee->wallet + $reward->reward_value
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

    public function update(Request $request, $reward_id) {

        $validate = Validator::make($request->all(), [
            'reward_value'     => ['required', 'integer'],
            'reason_for_reward' => ['required', 'string', 'max:255'],
            'employee_id'      => ['required', 'integer']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $reward = Reward::findOrFail($reward_id);

        // بنقص قيمة الحافز اللي اتزودت لهذا الموظف بالخطأ
        $reward->employee->update([
            'wallet' => $reward->employee->wallet - $reward->reward_value
        ]);
        
        $reward->update([
            'reward_value'     => $request->reward_value,
            'reason_for_reward' => $request->reason_for_reward,
            'employee_id'      => $request->employee_id
        ]);

        // بزود على رصيد الموظف الحافز اللي خده
        $reward->employee->update([
            'wallet' => $reward->employee->wallet + $reward->reward_value
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

    public function destroy($reward_id) {

        $reward = Reward::findOrFail($reward_id);

        // بنقص قيمة الحافز اللي اتزودت لهذا الموظف بالخطأ
        $reward->employee->update([
            'wallet' => $reward->employee->wallet - $reward->reward_value
        ]);

        $reward->delete();

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

}
