<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    return $user->projectMembers()->where('project_id', $projectId)->exists();
});
