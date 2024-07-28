<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
            'manager_id'    => ['integer', 'required']
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
            'employees' => ['required']
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
            'manager_id'    => ['integer', 'required']
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
                if ($task->delivered_time > $task->date) {

                    // سيتم اضافة مكافأة
                    foreach($task->employees as $employee) {

                        $task->employee->update([
                            'wallet' => $task->employee->wallet + $task->reward
                        ]);

                    }

                // لو سلمها بعد ميعاد التسليم 
                } elseif($task->delivered_time < $task->date) {

                    // سيتم اضافة خصم
                    foreach($task->employees as $employee) {

                        $task->employee->update([
                            'wallet' => $task->employee->wallet - $task->rival
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
                    'delivered_time' => NOW()
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
