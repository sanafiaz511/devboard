<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

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

        return response()->json([
            'success' => true
        ]);
    }
}
