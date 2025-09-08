<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }


    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];
}
