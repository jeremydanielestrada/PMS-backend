<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }

protected $fillable = [
    'name',
    'description',
    'owner_id',
    'due_date',
];

}
