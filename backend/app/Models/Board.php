<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function columns()
    {
        return $this->hasMany(BoardColumn::class);
    }
}
