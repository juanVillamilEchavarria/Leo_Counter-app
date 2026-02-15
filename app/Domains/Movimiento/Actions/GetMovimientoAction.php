<?php

namespace App\Domains\Movimiento\Actions;

use App\Models\Movimiento\Movimiento;
use App\Shared\Abstracts\Actions\GetAction;
use Illuminate\Support\Carbon;

class GetMovimientoAction extends GetAction{
    protected array $relations = ['cuenta', 'categoria', 'movimientoPendiente', 'tipo_movimiento'];
    public function __construct()
    {
        return parent::__construct(Movimiento::class);
    }
   protected function getDetailsRelations(): array{
        return array_merge($this->relations,['archivoMovimientos']);
    }
    public function getEspontaneoRecordsCount(): int{
        return Movimiento::where('movimiento_pendiente_id', null)->where('fecha', Carbon::now()->format('Y-m-d'))->count();
    }
}