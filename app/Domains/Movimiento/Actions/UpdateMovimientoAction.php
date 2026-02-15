<?php


namespace App\Domains\Movimiento\Actions;

use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Shared\Abstracts\Actions\UpdateAction;


/** @method Movimiento update(UpdateMovimientoDTO $dto) */
class UpdateMovimientoAction extends UpdateAction
{
   public function __construct()
   {
    parent::__construct(Movimiento::class);
   }
}