<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['board_column_id', 'title', 'description', 'position'];

    public function column()
    {
        return $this->belongsTo(BoardColumn::class, 'board_column_id');
    }
}
