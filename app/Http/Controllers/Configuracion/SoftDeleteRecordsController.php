<?php

namespace App\Http\Controllers\Configuracion;

use App\Domains\Configuracion\Services\Application\ConfiguracionService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class SoftDeleteRecordsController{
    public function __construct(
        private ConfiguracionService $configuracionService
    )
    {
    }
    public function index(string $domain){
        $domainFormated = ucfirst($domain);
        return Inertia::render("Configuracion/Deleted/{$domainFormated}",[
            'title' => "{$domainFormated} Eliminados",
            'data' => $this->configuracionService->getAllDeleted($domain)

        ]
        );
    }

    public function restore(Model $model, string $domain){
        return $this->configuracionService->restore($model, $domain);
    }

    public function hardDelete(Model $model, string $domain){
        return $this->configuracionService->hardDelete($model, $domain);
    }
}