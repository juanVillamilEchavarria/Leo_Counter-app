<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\MovimientoPendiente;

use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteWriteRepositoryContract;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class EloquentMovimientoPendienteWriteRepository extends EloquentWriteRepository implements MovimientoPendienteWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(MovimientoPendiente::class);
    }
}
