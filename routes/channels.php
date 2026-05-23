<?php

use Illuminate\Support\Facades\Broadcast;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;

Broadcast::channel('suscriptor.{suscriptorId}', function ($user, $suscriptorId) {
    $repository = app(SuscriptorNotificacionRepositoryContract::class);
    $suscriptor = $repository->findById(new SuscriptorId($suscriptorId));
    return $suscriptor && $user->id === $suscriptor->getUserId()->getValue();
});
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
