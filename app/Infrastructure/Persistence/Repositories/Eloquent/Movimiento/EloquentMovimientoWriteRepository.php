<?php
namespace App\Infrastructure\Persistence\Repositories\Eloquent\Movimiento;

use App\Application\Movimiento\DTOs\StoreMovimientoDTO;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoWriteRepositoryContract;
use App\Models\Movimiento\Movimiento;

class EloquentMovimientoWriteRepository extends EloquentWriteRepository implements MovimientoWriteRepositoryContract
{
    public function __construct()
    {
        parent::__construct(Movimiento::class);
    }
}