<?php
namespace App\Domains\Movimiento\Repositories\Application\Eloquent;

use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Movimiento\Repositories\Contracts\MovimientoWriteRepositoryContract;
use App\Models\Cuenta\Cuenta;
use App\Models\Movimiento\Movimiento;
use App\Shared\Abstracts\DTOs\DTO;

class EloquentMovimientoWriteRepository extends EloquentWriteRepository implements MovimientoWriteRepositoryContract
{
    public function __construct()
    {
        parent::__construct(Movimiento::class);
    }
    public function store(DTO $dto) {
        /** 
         * @var Movimiento $movimiento
         * @var StoreMovimientoDTO $dto
         *  */
        return parent::store($dto);
    }
}