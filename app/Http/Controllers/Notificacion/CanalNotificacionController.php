<?php

namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Application\Notificacion\Queries\ListAllCanalesNotificacionQuery;
use App\Application\Notificacion\Commands\ToggleCanalNotificacionCommand;
use Inertia\Inertia;

final class CanalNotificacionController extends Controller
{
    public function __construct(private QueryBus $queryBus, private Dispatcher $dispatcher){}

    public function index()
    {
        $canales = $this->queryBus->ask(new ListAllCanalesNotificacionQuery());
        return Inertia::render('Notificacion/Canales/Index', [
            'title' => 'Canales de Notificación',
            'canales' => $canales
        ]);
    }

    public function toggleActive(string $id)
    {
        $this->dispatcher->dispatch(new ToggleCanalNotificacionCommand(id: $id));
        Inertia::flash('success', 'Canal actualizado');
        return redirect()->route('notificacion.canales.index');
    }

}
