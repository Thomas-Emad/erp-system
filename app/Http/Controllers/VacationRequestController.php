<?php

namespace App\Http\Controllers;

use App\Models\VacationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacationRequestController extends Controller
{
    
    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'status'          => ['required', 'in:waiting,approved,rejected,expired'],
            'from'            => ['required', 'date'],
            'to'              => ['required', 'date'],
            'vacation_reason' => ['required', 'string', 'min:5', 'max:255'],
            'employee_id'     => ['required', 'integer', 'exists:users,id'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        VacationRequest::create([
            'status'          => $request->status,
            'from'            => $request->from,
            'to'              => $request->to,
            'vacation_reason' => $request->vacation_reason,
            'employee_id'     => $request->employee_id
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function update(Request $request, $id) {

        $validate = Validator::make($request->all(), [
            'status'          => ['required', 'in:waiting,approved,rejected,expired'],
            'from'            => ['required', 'date'],
            'to'              => ['required', 'date'],
            'vacation_reason' => ['required', 'string', 'min:5', 'max:255'],
            'employee_id'     => ['required', 'integer', 'exists:users,id'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        VacationRequest::findOrFail($id)->update([
            'status'          => $request->status,
            'from'            => $request->from,
            'to'              => $request->to,
            'vacation_reason' => $request->vacation_reason,
            'employee_id'     => $request->employee_id
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function delete($id) {

        $vacation = VacationRequest::where('id', $id)->where('status', '!=', 'approved')->first();
        if($vacation) {

            $vacation->delete();
            return response()->json([
                'message' => 'Suc'
            ]);

        }

        return response()->json([
            'message' => 'Un Suc'
        ]);

    }

}












            // خصم بسبب انه جه متأخر
        //     if($attendance->presence > $worker->roles->first()->start_work) {
                
        //         return 'true';
        //         // نحسب كم الوقت الذي تأخره
        //         $diff_in_hours = abs(now()->diffInHours($worker->roles->first()->start_work));
        //         $rival = Rival::create([
        //             'rival_value' => $worker->priceOneHourForWork() * $diff_in_hours,
        //             'reason_for_rival' => 'Because You Were Late' . $diff_in_hours . 'Hours',
        //             'employee_id' => $worker->id
        //         ]);

        //         $worker->update([
        //             'wallet' => $worker->wallet - $rival->rival_value
        //         ]);

        //     // حافز بسبب انه جه بدري
        //     } elseif($attendance->presence < $worker->roles->first()->start_work) {

        //         return 'no';
        //         // نحسب كم الوقت اللي جه بدري
        //         $diff_in_hours = abs(now()->diffInHours($worker->roles->first()->start_work));
        //         $reward = Reward::create([
        //             'reward_value' => $worker->priceOneHourForWork() * $diff_in_hours,
        //             'reason_for_reward' => 'Because You Came Early' . $diff_in_hours . 'Hours',
        //             'employee_id' => $worker->id
        //         ]);

        //         $worker->update([
        //             'wallet' => $worker->wallet + $reward->reward_value
        //         ]);

        //     }

        // } else {

        //     $attendance_worker->update([
        //         'departure' => now()
        //     ]);

        //     $worker->update([
        //         'wallet' => $worker->wallet + $worker->today_price
        //     ]);

        //     // خصم لانه مشي بدري عن ميعاده
        //     if($attendance_worker->departure < $worker->roles->first()->end_work) {
                
        //         // بنحسب الوقت اللي مشيه بدري
        //         $diff_in_hours = abs(now()->diffInHours($worker->roles->first()->end_work));
        //         $rival = Rival::create([
        //             'rival_value' => $worker->priceOneHourForWork() * $diff_in_hours,
        //             'reason_for_rival' => 'Because You Went Sooner' . $diff_in_hours . 'Hours',
        //             'employee_id' => $worker->id
        //         ]);

        //         $worker->update([
        //             'wallet' => $worker->wallet - $rival->rival_value
        //         ]);

        //     // حافز لانه اتاخر في الشغل
        //     } elseif($attendance_worker->departure > $worker->roles->first()->end_work) {

        //         // نحسب الوقت اللي جه اضافي
        //         $diff_in_hours = abs(now()->diffInHours($worker->roles->first()->end_work));
        //         $reward = Reward::create([
        //             'reward_value' => $worker->priceOneHourForWork() * $diff_in_hours,
        //             'reason_for_reward' => 'Because You Left Too Late' . $diff_in_hours . 'Hours',
        //             'employee_id' => $worker->id
        //         ]);

        //         $worker->update([
        //             'wallet' => $worker->wallet + $reward->reward_value
        //         ]);

        //     }