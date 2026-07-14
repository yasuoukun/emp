<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id || in_array($user->role, ['admin', 'super_admin']);
});

Broadcast::channel('chat.admin', function ($user) {
    return in_array($user->role, ['admin', 'super_admin']);
});
