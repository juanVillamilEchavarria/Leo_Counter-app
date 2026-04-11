<?php

namespace App\Http\Controllers\Configuracion;

use App\Application\Configuracion\Services\ConfiguracionService;
use Inertia\Inertia;

class SoftDeleteRecordsController{
    public function __construct(
        private ConfiguracionService $configuracionService
    )
    {
    }
    public function index(string $domain){
        $type = $this->configuracionService->resolveSoftDeleteManagerType($domain);
        return Inertia::render($type->view(),[
            'title' => "{$type->label()} Eliminados",
            'data' => $this->configuracionService->getAllDeleted($domain)

        ]
        );
    }

    public function restore( string $domain, int $id){
         $this->configuracionService->restore($id, $domain);
         Inertia::flash('success', 'Restaurado con exito');
         return back();
    }

    public function hardDelete( string $domain, int $id){
         $this->configuracionService->hardDelete($id, $domain);
         Inertia::flash('success', 'Eliminado con exito');
         return back();
    }
}