<?php

namespace App\Http\Controllers\Api\Notificacion;

use App\Application\Notificacion\Commands\DestroySuscriptorCommand;
use App\Application\Notificacion\Commands\StoreSuscriptorCommand;
use App\Application\Notificacion\Queries\ListSuscriptoresFormOptionsQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacion\StoreAndUpdateSuscriptorRequest;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Inertia\Inertia;

/**
 * API controller para Suscriptores de Notificación.
 *
 * NOTA: Se eliminó la funcionalidad de edición/actualización.
 * Solo se exponen endpoints para store (crear) y destroy (eliminar).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
class SuscriptorApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $dispatcher
    )
    {
    }

    public function store(StoreAndUpdateSuscriptorRequest $request)
    {
       $id = $this->dispatcher->dispatch(new StoreSuscriptorCommand(
            user_id: $request->user_id,
            canal_notificacion_id: $request->canal_notificacion_id
        ));
        Inertia::flash('success', 'Suscripción creada');
        return response()->json(['id'=>$id], 201);
    }
    public function destroy(string $id)
    {
        $this->dispatcher->dispatch(new DestroySuscriptorCommand(id: $id));
        Inertia::flash('success', 'Suscripción eliminada');
        return response()->json(null, 204);
    }

    public function formOptions(){
        $suscriptores = $this->queryBus->ask(new ListSuscriptoresFormOptionsQuery());
        return response()->json($suscriptores);
    }
    //
}
