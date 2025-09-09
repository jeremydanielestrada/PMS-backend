<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTask extends Model
{

    public function task():BelongsTo{

        return $this->belongsTo(Task::class,'task_id');
    }




    protected $fillable = [
        'task_id',
        'title',
        'is_completed'
    ];
}
