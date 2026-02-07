<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\Shared\Enums\ComparativeOperators;
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

    public function getHistoricRecordsCount(): int{
        return Presupuesto::whereDate('periodo', '<=', Carbon::now()->firstOfMonth())
        ->count();
    }

    public function getMesActualRecordsCount(): int
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
    public function getAllWithDetailsUntilPeriodo(ComparativeOperators $operator, Carbon | string $periodo): Collection{
        return $this->baseQueryWithDetails()->whereDate('periodo', $operator->value, $periodo)->get();
    }
}
