<?php

namespace App\Http\Controllers\Configuracion;

use App\Application\Configuracion\Commands\HardDeleteRecordCommand;
use App\Application\Configuracion\Commands\RestoreRecordCommand;
use App\Application\Configuracion\Queries\ListDomainRecordsDeletedQuery;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;
use App\Application\Configuracion\Resolvers\DeletedRecordsResourceResolver;

class SoftDeleteRecordsController{
    public function __construct(
        private QueryBus $queryBus,
        private Dispatcher $dispatcher,
        private DeletedRecordsResourceResolver $resourceResolver,
    )
    {
    }
    public function index(string $domain){
        $type = SoftDeleteManagerTypes::try($domain);
        $data = $this->queryBus->ask(new ListDomainRecordsDeletedQuery($type));
        $resource = $this->resourceResolver->resolve($type, $data);

        return Inertia::render($this->viewByType($type),[
            'title' => "{$type->label()} Eliminados",
            'data' => $resource

        ]
        );
    }

    public function restore( string $domain, string $id){
         $type = SoftDeleteManagerTypes::try($domain);
         $this->dispatcher->dispatch(new RestoreRecordCommand(id: $id, domain: $type));
         Inertia::flash('success', 'Restaurado con exito');
         return back();
    }

    public function hardDelete( string $domain, string $id){
         $type = SoftDeleteManagerTypes::try($domain);
         $this->dispatcher->dispatch(new HardDeleteRecordCommand(id: $id, domain: $type));
         Inertia::flash('success', 'Eliminado con exito');
         return back();
    }

    private function viewByType( SoftDeleteManagerTypes $type){
        $baseUrl = 'Configuracion/Deleted/';
        return match($type){
            SoftDeleteManagerTypes::CUENTAS =>  $baseUrl.'Cuentas',
            SoftDeleteManagerTypes::CATEGORIAS => $baseUrl. 'Categorias',
            SoftDeleteManagerTypes::MOVIMIENTOS_PENDIENTES => $baseUrl. 'MovimientosPendientes',
            SoftDeleteManagerTypes::PRESUPUESTOS => $baseUrl. 'Presupuestos',
        };
    }
}
