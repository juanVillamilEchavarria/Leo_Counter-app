<?php
namespace App\Domains\Movimiento\Actions;

use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Models\Movimiento\Movimiento;
use App\Shared\Abstracts\Actions\StoreAction;


/** @method Movimiento store(StoreMovimientoDTO $dto) */
class StoreMovimientoAction extends StoreAction{

    public function __construct()
    {
        parent::__construct(Movimiento::class);
    }
}