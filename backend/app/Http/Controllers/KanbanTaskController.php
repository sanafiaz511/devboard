<?php

namespace App\Http\Controllers;

use App\Events\ActivityCreated;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Events\TaskMoved;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class KanbanTaskController extends Controller
{
    public function move(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'board_column_id' => 'required|exists:board_columns,id',
            'position' => 'required|integer'
        ]);

        $task = Task::findOrFail($request->task_id);

        $task->update([
            'board_column_id' => $request->board_column_id,
            'position' => $request->position,
        ]);

        broadcast(new TaskMoved($task))->toOthers();

        $activity = Activity::create([
            'user_id' => Auth::id(),
            'type' => 'task_moved',
            'message' => 'Task moved to another column',
            'meta' => [
                'task_id' => $task->id,
                'column_id' => $task->board_column_id,
            ]
        ]);

        broadcast(new ActivityCreated($activity))->toOthers();

        return response()->json([
            'success' => true
        ]);
    }
}
