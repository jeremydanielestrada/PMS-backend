<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMember extends Model
{

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }

     public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }


    protected $fillable = [
        'project_id',
        'user_id',
        'role',
    ];
}
