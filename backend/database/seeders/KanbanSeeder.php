<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Board;
use App\Models\BoardColumn;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class KanbanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE tasks RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE board_columns RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE boards RESTART IDENTITY CASCADE');
        $board = Board::create([
            'user_id' => 1,
            'name' => 'My First Board',
        ]);

        $columns = [
            'To Do',
            'In Progress',
            'Done'
        ];

        foreach ($columns as $index => $name) {
            $column = BoardColumn::create([
                'board_id' => $board->id,
                'name' => $name,
                'position' => $index,
            ]);

            // 🔥 ADD SAMPLE TASKS
            Task::create([
                'board_column_id' => $column->id,
                'title' => $name . ' Task 1',
            ]);

            Task::create([
                'board_column_id' => $column->id,
                'title' => $name . ' Task 2',
            ]);
        }
    }
}
