<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\Presupuesto\Resources\PresupuestoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Carbon\Carbon;

class GetPresupuestoAction
{

    private function baseQueyWithDetails(){
        return Presupuesto::query()
        ->with(['categoria', 'tipoPresupuesto', 'user']);
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
        return Presupuesto::whereDate('fecha_inicio', '<=', $now)
        ->whereDate('fecha_final', '>=', $now)
        ->count();
    }

    public function getRecordsCountPorPeriodo(): int
    {
        return Presupuesto::whereRaw('DATEDIFF(fecha_final, fecha_inicio) > 30') // duración mayor a un mes
        ->where('fecha_final', '>', Carbon::today())         // solo vigentes o futuros
        ->count();
    }


    public function getAllWithDetails(): AnonymousResourceCollection
    {
        $presupuestos = $this->baseQueyWithDetails()->get();
        return PresupuestoResource::collection($presupuestos);
    }

    public function getPorPeriodoWithDetails(): AnonymousResourceCollection{
        $presupuestosPorPeriodo = $this->baseQueyWithDetails()
        ->whereRaw('DATEDIFF(fecha_final, fecha_inicio) > 30') // duración mayor a un mes
        ->where('fecha_final', '>', Carbon::today())         // solo vigentes o futuros
        ->orderBy('fecha_inicio', 'asc')
        ->get();
            return PresupuestoResource::collection($presupuestosPorPeriodo);
    }

    public function getActualMesWithDetails(): AnonymousResourceCollection
    {
        $now = Carbon::now();
        $presupuestos = $this->baseQueyWithDetails()
            ->whereDate('fecha_inicio', '=', $now->firstOfMonth())
            ->whereDate('fecha_final', '=', $now->lastOfMonth())
            ->get();
        return PresupuestoResource::collection($presupuestos);
    }
}
