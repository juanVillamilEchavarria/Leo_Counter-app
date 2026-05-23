<?php

namespace App\Http\Controllers\Notificacion;

use App\Application\Notificacion\Commands\DestroySuscriptorCommand;
use App\Application\Notificacion\Commands\StoreSuscriptorCommand;
use App\Application\Notificacion\Commands\ToggleSuscriptorCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacion\StoreAndUpdateSuscriptorRequest;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;

/**
 * Controlador de Suscriptores de Notificación.
 *
 * NOTA: La funcionalidad de edición/actualización fue removida.
 * Solo se mantienen store (crear), destroy (eliminar) y toggleActive (habilitar/deshabilitar).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final class SuscriptorController extends Controller
{
    public function __construct( private Dispatcher $dispatcher){}

    public function toggle(string $id, string $attribute)
    {
        $this->dispatcher->dispatch(new ToggleSuscriptorCommand(id: $id, attribute: $attribute));
        Inertia::flash('success', 'Suscripción actualizada');
        return redirect()->route('configuracion.index');
    }
}
