<?php

namespace App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class EloquentMovimientoPendienteRepository extends EloquentRepository implements MovimientoPendienteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(MovimientoPendiente::class);
    }
}
