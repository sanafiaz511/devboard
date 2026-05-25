<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Board;
use App\Models\BoardColumn;

class KanbanSeeder extends Seeder
{

    public function run(): void
    {
        $board = Board::create([
            'user_id' => 1,
            'name' => 'My First Board',
        ]);

        $columns = ['To Do', 'In Progress', 'Done'];

        foreach ($columns as $index => $name) {
            BoardColumn::create([
                'board_id' => $board->id,
                'name' => $name,
                'position' => $index,
            ]);
        }
    }
}
