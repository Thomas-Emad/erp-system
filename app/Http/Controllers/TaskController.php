<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Rival;
use App\Models\Reward;
use App\Models\EmployeeTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function store(Request $request) {

        $validate = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'min:3', 'max:50'],
            'description'   => ['string', 'required', 'min:7', 'max:255'],
            'deadline'      => ['required', 'date'],
            'reward'        => ['required', 'integer'],
            'rival'         => ['required', 'integer'],
            'manager_id'    => ['integer', 'required', 'exists:users,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        Task::create([
            'name'        => $request->name,
            'description' => $request->description,
            'deadline'    => $request->deadline,
            'reward'      => $request->reward,
            'rival'       => $request->rival,
            'manager_id'  => $request->manager_id
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

    public function add_employee_for_task(Request $request, $task_id) {

        $validate = Validator::make($request->all(), [
            'employees'   => ['required', 'array'],
            'employees.*' => ['exists:users,id'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $task = Task::where('id', $task_id)
                ->where('status', '!=' ,'delivered')
                ->where('status', '!=', 'approved')->first();

        if($task) {

            foreach($request->employees as $employee) {

                EmployeeTask::create([
                    'employee_id' => $employee,
                    'task_id'     => $task_id
                ]);

            }

            return response()->json([
                'Message' => 'Suc'
            ]);

        }

        return response()->json([
            'Message' => 'Wrong'
        ]);

    }

    public function update(Request $request, $task_id) {

        $validate = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'min:3', 'max:50'],
            'description'   => ['string', 'required', 'min:7', 'max:255'],
            'deadline'      => ['required', 'date'],
            'reward'        => ['required', 'integer'],
            'rival'         => ['required', 'integer'],
            'manager_id'    => ['integer', 'required', 'exists:users,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        Task::findOrFail($task_id)->update([
            'name'        => $request->name,
            'description' => $request->description,
            'deadline'    => $request->deadline,
            'reward'      => $request->reward,
            'rival'       => $request->rival,
            'manager_id'  => $request->manager_id
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

    public function modify_status_by_admin(Request $request, $task_id) {

        $validate = Validator::make($request->all(), [
            'status' => ['required']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $task = Task::where('id', $task_id)->where('status', '=', 'delivered')->first();

        if($task) {

            if ($request->status == 'approved') {

                $task->update([
                    'status' => 'approved'
                ]);

                // لو سلمها قبل ميعاد التسليم
                if ($task->delivered_time < $task->date) {

                    $task->manager->update([
                        'wallet' => $task->manager->wallet + $task->reward
                    ]);

                    Reward::create([
                        'reward_value' => $task->reward,
                        'reason_for_reward' => 'Because You Accomplished The Task',
                        'employee_id' => $task->manager->id
                    ]);

                    // سيتم اضافة مكافأة
                    foreach($task->employees as $employee) {

                        $employee->update([
                            'wallet' => $employee->wallet + $task->reward
                        ]);

                        Reward::create([
                            'reward_value' => $task->reward,
                            'reason_for_reward' => 'Because You Accomplished The Task',
                            'employee_id' => $employee->id
                        ]);

                    }

                // لو سلمها بعد ميعاد التسليم 
                } elseif($task->delivered_time > $task->date) {

                    $task->manager->update([
                        'wallet' => $task->manager->wallet - $task->rival
                    ]);

                    Rival::create([
                        'rival_value' => $task->rival,
                        'reason_for_rival' => 'Because You Were Bad In The Task',
                        'employee_id' => $task->manager->id
                    ]);

                    // سيتم اضافة خصم
                    foreach($task->employees as $employee) {

                        $employee->update([
                            'wallet' => $employee->wallet - $task->rival
                        ]);

                        Rival::create([
                            'rival_value' => $task->rival,
                            'reason_for_rival' => 'Because You Were Bad In The Task',
                            'employee_id' => $employee->id
                        ]);

                    }

                }

                return response()->json([
                    'Message' => 'Suc'
                ]);

            }

        }

        return response()->json([
            'Message' => 'Wrong'
        ]);

    }


    public function modify_status_by_manager(Request $request, $task_id) {

        $validate = Validator::make($request->all(), [
            'status' => ['required']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }
        
        $task = Task::where('id', $task_id)->where('status', '!=', 'approved')->first();

        if($task) {

            if($request->status == 'delivered') {

                $task->update([
                    'status'         => 'delivered',
                    'delivered_time' => now()
                ]);

            } else {

                $task->update([
                    'status' => $request->status
                ]);

            }

            return response()->json([
                'Message' => 'Suc'
            ]);

        }

        return response()->json([
            'Message' => 'Wrong'
        ]);

    }
    
}
