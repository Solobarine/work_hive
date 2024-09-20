<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('tasks.{task_id}', function (User $user, int $task_id) {
    return $user->id === Task::firstOrNew($task_id)->user_id;
});
