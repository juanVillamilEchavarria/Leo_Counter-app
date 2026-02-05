<?php

namespace App\Domains\Movimiento\Service;

use App\Domains\Movimiento\Actions\GetMovimientoAction;
use App\Domains\Movimiento\Actions\StoreMovimientoAction;
use App\Domains\Movimiento\Resources\MovimientoResource;
use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\Resources\MovimientoShowResource;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovimientoService{
    public function __construct(
        private GetMovimientoAction $getMovimientoAction,
        private StoreMovimientoAction $storeMovimientoAction
    )
    {
    }

    public function getWithDetails(Movimiento $movimiento) : MovimientoShowResource{
        return MovimientoShowResource::make($this->getMovimientoAction->getWithDetails($movimiento));
    }

    public function getAll() : AnonymousResourceCollection{
         return MovimientoResource::collection($this->getMovimientoAction->getAllWithDetails());
    }
    public function getRecordsCount(): int{
        return $this->getMovimientoAction->getRecordsCount();
    }
}