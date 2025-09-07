<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{

     public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }

    public function project_members():HasMany{

        return $this->hasMany(ProjectMember::class,'project_id');
    }

protected $fillable = [
    'name',
    'description',
    'owner_id',
    'due_date',
];

}
