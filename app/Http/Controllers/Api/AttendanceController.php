<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Rival;
use App\Models\Reward;
use Carbon\Carbon;




class AttendanceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:attendance')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'attendance_today' => Attendance::whereDate('created_at', now()->today())->count(),
            'attendances' => Attendance::whereDate('created_at', now()->today())->get(),
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        if (!$validator->fails()) {
            try {
                $worker = User::where('id', $request->worker_id)->first();
                $attendanceWorker = Attendance::where('worker_id', $request->worker_id)->whereDate("created_at", now()->today())->latest()->first();

                // check from IF Time Work is ended
                if (now()->diffInSeconds(Carbon::createFromFormat("H:i:s", $worker->roles->first()->end_work)) > 0) {
                    // Check if user have attendance
                    if (empty($attendanceWorker)) {
                        $this->checkInAttendance($request, $worker);
                    } elseif ($attendanceWorker->departure == null) {
                        $this->checkOutAttendance($attendanceWorker, $worker);
                    } else {
                        return response()->json([
                            'message' => 'The user has been logged in and out previously'
                        ], 200);
                    }
                    return response()->json([
                        'message' => 'Mission Accomplished successfully'
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'Work time is over, you can\'t log in now'
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => "Something is wrong!!",
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
    }

    private function checkInAttendance($request, $worker)
    {
        Attendance::create([
            'worker_id' => $request->worker_id,
            'presence' => now(),
        ]);

        // Calc Value Rival and do it it exist
        if (Carbon::createFromFormat("H:i:s", $worker->roles->first()->start_work) < now()) {
            $delayTime =  $this->delayTime($worker->roles->first()->start_work);
            Rival::create([
                'rival_value' => ($delayTime * $worker->priceOneHourForWork()),
                'reason_for_rival' => 'Delay form work (' . abs(round($delayTime)) . ')',
                'employee_id' => $worker->id
            ]);
        }
    }
    private function checkOutAttendance($attendanceWorker, $worker)
    {
        $attendanceWorker->departure = now();
        $attendanceWorker->save();

        // Calc Value Reward and do it
        $delayTime =  $this->delayTime($worker->roles->first()->end_work);
        $worker->wallet += $this->calcPriceForDuration($attendanceWorker->presence, $attendanceWorker->departure, $worker->priceOneHourForWork());
        $worker->save();

        if (Carbon::createFromFormat("H:i:s", $worker->roles->first()->end_work)->diffInSeconds($attendanceWorker->departure) > 0) {
            Reward::create([
                'reward_value' => ($delayTime * $worker->priceOneHourForWork()),
                'reason_for_reward' => 'Extra Time (' . round($delayTime) . ')',
                'employee_id' => $worker->id
            ]);
        }
    }

    private  function calcPriceForDuration($startWorking, $endWorking, $priceOneHour)
    {
        // Calc Diff for seconds
        $diffInSeconds = abs(Carbon::make($endWorking)->diffInSeconds($startWorking));
        $hours = $diffInSeconds / 3600;

        // Calc the Price working for this time
        $priceToday =  $priceOneHour *  $hours;
        return $priceToday;
    }
    private  function delayTime($time)
    {
        $time =  Carbon::createFromFormat("H:i:s", $time);
        $now = now();

        // Calc Diff for seconds
        $diffInSeconds = abs($now->diffInSeconds($time));
        $hours = $diffInSeconds / 3600;
        return $hours;
    }
}
