<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'users_id');
    }
      public function project():BelongsTo
    {
        return $this->belongsTo(Project::class,'projects_id');
    }




    protected $fillable = [
        'users_id',
        'projects_id',
        'action'
    ];
}
