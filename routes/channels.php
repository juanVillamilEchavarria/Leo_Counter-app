<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\Notificacion\SuscriptorNotificacion;

Broadcast::channel('suscriptor.{suscriptorId}', function ($user, $suscriptorId) {
    $suscriptor = SuscriptorNotificacion::find($suscriptorId);
    return $suscriptor !== null;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
