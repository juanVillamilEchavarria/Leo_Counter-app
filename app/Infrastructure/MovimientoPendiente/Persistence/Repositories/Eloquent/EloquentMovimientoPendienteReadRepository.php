<?php

namespace App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent;

use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentReadRepository;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class EloquentMovimientoPendienteReadRepository extends EloquentReadRepository implements MovimientoPendienteReadRepositoryContract {

    protected array $relations = ['cuenta', 'categoria', 'tipo_movimiento', 'movimiento_fijo'];

    public function __construct()
    {
        parent::__construct(MovimientoPendiente::class);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection{
        return MovimientoPendiente::with($this->relations)->where('estado', \App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente::PENDIENTE->value)->get();
    }


    public function getRecordsCount(): int{
        return MovimientoPendiente::count();
    }

    public function getAvailableRecordsCount(): int{
        return MovimientoPendiente::where('estado', \App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente::PENDIENTE->value)->count();
    }

}
