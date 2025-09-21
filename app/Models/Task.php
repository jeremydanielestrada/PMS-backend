<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }


    public function subtasks():HasMany{

        return $this->hasMany(SubTask::class,'task_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
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
