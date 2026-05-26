<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Inertia\Inertia;

class KanbanController extends Controller
{
    public function index()
    {
        $board = Board::with([
            'columns' => function ($q) {
                $q->orderBy('position');
            },
            'columns.tasks' => function ($q) {
                $q->orderBy('position');
            }
        ])->first();

        return Inertia::render('Kanban/Index', [
            'board' => $board
        ]);
    }
}
