<?php
namespace App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent;

use App\Application\Movimiento\DTOs\StoreMovimientoDTO;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Models\Movimiento\Movimiento;

class EloquentMovimientoRepository extends EloquentRepository implements MovimientoRepositoryContract
{
    public function __construct()
    {
        parent::__construct(Movimiento::class);
    }
}