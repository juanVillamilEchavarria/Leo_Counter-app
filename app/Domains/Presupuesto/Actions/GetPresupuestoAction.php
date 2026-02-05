<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO;

class GetPresupuestoAction
{

    private function baseQueryWithDetails(){
        return Presupuesto::query()
        ->with(['categoria', 'user']);
    }
    public function getAll(): Collection
    {
        return Presupuesto::all();
    }

    public function getRecordsCount(): int
    {
        return Presupuesto::count();
    }

    public function getRecordsCountMesActual(): int
    {
        $now = Carbon::now();
        return Presupuesto::whereDate('periodo', '=', $now->firstOfMonth())
        ->count();
    }

    public function getAllWithDetails(): Collection
    {
        return $this->baseQueryWithDetails()->get();
    }
     public function getEqualPresupuesto(int $categoria_id, Carbon | string $periodo): mixed{
        return Presupuesto::query()
            ->where('categoria_id', $categoria_id)
            ->whereDate('periodo', $periodo);

    }

    public function getActualMesWithDetails(): Collection
    {
        $now = Carbon::now();
        return $this->baseQueryWithDetails()
            ->whereDate('periodo', '=', $now->firstOfMonth())
            ->get();
    }
}
