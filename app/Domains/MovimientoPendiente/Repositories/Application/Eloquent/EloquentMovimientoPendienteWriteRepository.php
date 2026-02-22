<?php

namespace App\Domains\MovimientoPendiente\Repositories\Application\Eloquent;

use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\MovimientoPendiente\Repositories\Contracts\MovimientoPendienteWriteRepositoryContract;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class EloquentMovimientoPendienteWriteRepository extends EloquentWriteRepository implements MovimientoPendienteWriteRepositoryContract
{
    public function __construct()
    {
        return parent::__construct(MovimientoPendiente::class);
    }
}
