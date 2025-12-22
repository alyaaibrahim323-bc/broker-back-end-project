<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



Broadcast::channel('unitevent ', function ($user) {
    return true; // السماح بالوصول للجميع
});


// Broadcast::channel('notifications', function ($user) {
//     return true; // السماح لجميع المستخدمين بالاستماع للإشعارات
// });
// Broadcast::channel('notifications', function ($user) {
//     return $user->hasRole('super-admin'); // فقط السوبر أدمن
// });
