<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Application\Notificacion\Queries\ListAllCanalesNotificacionQuery;
use App\Application\Notificacion\Commands\ToggleCanalCommand;
use Inertia\Inertia;

final class CanalNotificacionController extends Controller
{
    public function __construct( private Dispatcher $dispatcher){}

    public function toggle(string $id, string $atribute)
    {
        $this->dispatcher->dispatch(new ToggleCanalCommand(id: $id, attribute: $atribute));
        Inertia::flash('success', 'Canal actualizado');
        return redirect()->route('configuracion.index');
    }

}
