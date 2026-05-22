<?php

namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Application\Notificacion\Queries\ListAllSuscriptoresWithDetailsQuery;
use App\Application\Notificacion\Commands\StoreSuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\UpdateSuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\DestroySuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\ToggleSuscriptorNotificacionCommand;
use Inertia\Inertia;

final class SuscriptorNotificacionController extends Controller
{
    public function __construct(private QueryBus $queryBus, private Dispatcher $dispatcher){}

    public function index()
    {
        $suscriptores = $this->queryBus->ask(new ListAllSuscriptoresWithDetailsQuery());
        return Inertia::render('Notificacion/Suscriptores/Index', [
            'title' => 'Suscriptores de Notificación',
            'suscriptores' => $suscriptores
        ]);
    }

    public function store()
    {
        $this->dispatcher->dispatch(new StoreSuscriptorNotificacionCommand(
            user_id: request()->input('user_id'),
            canal_notificacion_id: request()->input('canal_notificacion_id')
        ));
        Inertia::flash('success', 'Suscripción creada');
        return redirect()->route('notificacion.suscriptores.index');
    }

    public function update(string $id)
    {
        $this->dispatcher->dispatch(new UpdateSuscriptorNotificacionCommand(
            id: $id,
            user_id: request()->input('user_id'),
            canal_notificacion_id: request()->input('canal_notificacion_id')
        ));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('notificacion.suscriptores.index');
    }

    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroySuscriptorNotificacionCommand(id: $id));
        Inertia::flash('success', 'Suscripción eliminada');
        return redirect()->route('notificacion.suscriptores.index');
    }

    public function toggleActive(string $id)
    {
        $this->dispatcher->dispatch(new ToggleSuscriptorNotificacionCommand(id: $id));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('notificacion.suscriptores.index');
    }
}
