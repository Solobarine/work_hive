<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'tasks' => auth()->user()->tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "title" => 'required|string|max:255',
            "description" => 'required|string',
            "status" => "sometimes|in:pending,ongoing,completed",
            "priority" => "sometimes|in:high,medium,low",
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

        $task = Task::create([
            "user_id" => auth()->user()->id,
            "title" => $request->title,
            "description" => $request->description,
            "status" => $request->status ?? "pending",
            "priority" => $request->priority ?? "low"
        ]);

        return response()->json([
            'status' => true, 'task' => $task
        ]);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json([
            'status' => true,
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validate = Validator::make($request->all(), [
            "title" => 'sometimes|string|max:255',
            "description" => 'sometimes|string',
            "status" => "sometimes|in:pending,ongoing,completed",
            "priority" => "sometimes|in:high,medium,low",
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ], 422);
        }

        $task->title = $request->title ?? $task->title;
        $task->description = $request->description ?? $task->description;
        $task->status = $request->status ?? $task->status;
        $task->priority = $request->priority ?? $task->priority;

        $task->save();

        return response()->json([
            'status' => true,
            'message' => 'Task Updated Successfully',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Task Deleted Successfully',
            'task' => $task
        ]);
    }
}
