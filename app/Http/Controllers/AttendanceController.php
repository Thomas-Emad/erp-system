<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Rival;
use App\Models\Reward;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    
    public function store(Request $request) {

        $now = Carbon::createFromFormat("H:i:s", now()->format('H:i:s'));
        $validate = Validator::make($request->all(), [
            'worker_id' => ['required', 'integer', 'exists:users,id'],
        ]);
        
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $worker = User::where('id', $request->worker_id)->first();
        $attendance_worker = Attendance::where('worker_id', $request->worker_id)->where('day', now()->format('Y-m-d'))->first();

        if(!$attendance_worker) {

            $attendance = Attendance::create([
                'presence'  => now()->format('H:i:s'), 
                'day'       => now()->format('Y-m-d'), 
                'worker_id' => $request->worker_id
            ]);

            // حافز
            if(Carbon::createFromFormat("H:i:s", $attendance->presence) < Carbon::createFromFormat("H:i:s", $worker->roles->first()->start_work)) {

                // نحسب كم الوقت اللي جه بدري
                $diff_in_hours = abs($now->diffInHours(Carbon::createFromFormat("H:i:s", $worker->roles->first()->start_work)));
                $reward = Reward::create([
                    'reward_value' => $worker->priceOneHourForWork() * $diff_in_hours,
                    'reason_for_reward' => 'Because You Came Early' . $diff_in_hours . 'Hours',
                    'employee_id' => $worker->id
                ]);

                $worker->update([
                    'wallet' => $worker->wallet + $reward->reward_value
                ]);

            // خصم
            } elseif(Carbon::createFromFormat("H:i:s", $attendance->presence) > Carbon::createFromFormat("H:i:s", $worker->roles->first()->start_work)) {

                // نحسب كم الوقت اللي جه متاخر
                $diff_in_hours = abs($now->diffInHours(Carbon::createFromFormat("H:i:s", $worker->roles->first()->start_work)));
                $rival = Rival::create([
                    'rival_value' => $worker->priceOneHourForWork() * $diff_in_hours,
                    'reason_for_rival' => 'Because You Were Late' . $diff_in_hours . 'Hours',
                    'employee_id' => $worker->id
                ]);

                $worker->update([
                    'wallet' => $worker->wallet - $rival->rival_value
                ]);

            }

        } else {

            $attendance_worker->update([
                'departure' => now()->format('H:i:s')
            ]);

            $worker->update([
                'wallet' => $worker->wallet + $worker->today_price
            ]);

            // خصم لانه مشي بدري عن ميعاده
            if(Carbon::createFromFormat("H:i:s", $attendance_worker->departure) < Carbon::createFromFormat("H:i:s", $worker->roles->first()->end_work)) {
                
                // بنحسب الوقت اللي مشيه بدري
                $diff_in_hours = abs($now->diffInHours(Carbon::createFromFormat("H:i:s", $worker->roles->first()->end_work)));
                $rival = Rival::create([
                    'rival_value' => $worker->priceOneHourForWork() * $diff_in_hours,
                    'reason_for_rival' => 'Because You Went Sooner' . $diff_in_hours . 'Hours',
                    'employee_id' => $worker->id
                ]);

                $worker->update([
                    'wallet' => $worker->wallet - $rival->rival_value
                ]);

            // حافز لانه اتاخر في الشغل
            } elseif(Carbon::createFromFormat("H:i:s", $attendance_worker->departure) > Carbon::createFromFormat("H:i:s", $worker->roles->first()->end_work)) {

                // نحسب الوقت اللي جه اضافي
                $diff_in_hours = abs($now->diffInHours(Carbon::createFromFormat("H:i:s", $worker->roles->first()->end_work)));
                $reward = Reward::create([
                    'reward_value' => $worker->priceOneHourForWork() * $diff_in_hours,
                    'reason_for_reward' => 'Because You Left Too Late' . $diff_in_hours . 'Hours',
                    'employee_id' => $worker->id
                ]);

                $worker->update([
                    'wallet' => $worker->wallet + $reward->reward_value
                ]);

            }

        }

        return response()->json([
            'message' => 'Suc'
        ]);

    }

}
