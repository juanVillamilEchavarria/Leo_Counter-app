<?php

namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoEspontaneo\StoreMovimientoEspontaneoRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Application\Notificacion\Queries\ListAllSuscriptoresWithDetailsQuery;
use App\Application\Notificacion\Commands\StoreSuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\UpdateSuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\DestroySuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\ToggleSuscriptorNotificacionCommand;
use Inertia\Inertia;
use App\Http\Requests\StoreSuscriptorNotificacionRequest;

final class SuscriptorNotificacionController extends Controller
{
    public function __construct( private Dispatcher $dispatcher){}


    public function store( StoreSuscriptorNotificacionRequest $request)
    {
        dd($request->all());
        $this->dispatcher->dispatch(new StoreSuscriptorNotificacionCommand(
            user_id: $request->user_id,
            canal_notificacion_id: $request->canal_notificacion_id
        ));
        Inertia::flash('success', 'Suscripción creada');
        return redirect()->route('configuracion.index');
    }

    public function update(string $id)
    {
        $this->dispatcher->dispatch(new UpdateSuscriptorNotificacionCommand(
            id: $id,
            user_id: request()->input('user_id'),
            canal_notificacion_id: request()->input('canal_notificacion_id')
        ));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('configuracion.index');
    }

    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroySuscriptorNotificacionCommand(id: $id));
        Inertia::flash('success', 'Suscripción eliminada');
        return redirect()->route('configuracion.index');
    }

    public function toggleActive(string $id)
    {
        $this->dispatcher->dispatch(new ToggleSuscriptorNotificacionCommand(id: $id));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('configuracion.index');
    }
}
