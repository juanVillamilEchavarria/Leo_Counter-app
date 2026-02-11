<?php

namespace App\Domains\Movimiento\Actions;

use App\Models\Movimiento\Movimiento;
use App\Shared\Enums\ComparativeOperators;
use App\Shared\DTOs\WhereFilterQueryDTO;
use Illuminate\Support\Carbon;
use App\Domains\Movimiento\Resources\MovimientoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetMovimientoAction{

    private array $relations = ['cuenta', 'categoria', 'movimientoPendiente', 'tipo_movimiento'];

    private function allDetails(){
        return Movimiento::query()->with($this->relations);
    }

    public function getAllWithDetailsWhere(array $wheres){
        $data =$this->allDetails();
        /** @var WhereFilterQueryDTO[] $wheres */
        foreach($wheres as $where){
            $data->where($where->column, $where->operator->value, $where->value, $where->logic);
        }
        return $data->get();
    }

    public function getAllWithDetails(){
        return $this->allDetails()->get();
    }

    public function getWithDetails(Movimiento $movimiento){
        $relations = array_merge($this->relations, ['archivoMovimientos']);
        return $movimiento->load($relations);
    }

    public function getRecordsCount(): int{
        return Movimiento::count();
    }

    public function getEspontaneoRecordsCount(): int{
        return Movimiento::where('movimiento_pendiente_id', null)->where('fecha', Carbon::now()->format('Y-m-d'))->count();
    }
}