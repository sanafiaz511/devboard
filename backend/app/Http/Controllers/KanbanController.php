<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Inertia\Inertia;

class KanbanController extends Controller
{
    public function index()
    {
        $board = Board::with('columns.tasks')->first();
 
        return Inertia::render('Kanban/Index', [
            'board' => $board
        ]);
    }
}
