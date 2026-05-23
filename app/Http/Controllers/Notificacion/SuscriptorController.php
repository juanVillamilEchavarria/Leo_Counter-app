<?php

namespace App\Http\Controllers\Notificacion;

use App\Application\Notificacion\Commands\DestroySuscriptorCommand;
use App\Application\Notificacion\Commands\StoreSuscriptorCommand;
use App\Application\Notificacion\Commands\ToggleSuscriptorCommand;
use App\Application\Notificacion\Commands\UpdateSuscriptorCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacion\StoreAndUpdateSuscriptorRequest;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;

final class SuscriptorController extends Controller
{
    public function __construct( private Dispatcher $dispatcher){}

    public function store(StoreAndUpdateSuscriptorRequest $request)
    {
        $this->dispatcher->dispatch(new StoreSuscriptorCommand(
            user_id: $request->user_id,
            canal_notificacion_id: $request->canal_notificacion_id
        ));
        Inertia::flash('success', 'Suscripción creada');
        return redirect()->route('configuracion.index');
    }

    public function update(string $id)
    {
        $this->dispatcher->dispatch(new UpdateSuscriptorCommand(
            id: $id,
            user_id: request()->input('user_id'),
            canal_notificacion_id: request()->input('canal_notificacion_id')
        ));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('configuracion.index');
    }

    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroySuscriptorCommand(id: $id));
        Inertia::flash('success', 'Suscripción eliminada');
        return redirect()->route('configuracion.index');
    }

    public function toggleActive(string $id)
    {
        $this->dispatcher->dispatch(new ToggleSuscriptorCommand(id: $id));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('configuracion.index');
    }
}
