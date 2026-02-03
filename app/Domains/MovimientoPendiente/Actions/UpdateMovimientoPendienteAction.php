<?php

namespace App\Domains\MovimientoPendiente\Actions;

use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Domains\MovimientoPendiente\DTOs\UpdateMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\DTOs\MarkMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\Exceptions\CannotUpdateMovimientoPendienteException;

class UpdateMovimientoPendienteAction{

    public function update(MovimientoPendiente $movimientoPendiente, UpdateMovimientoPendienteDTO  | MarkMovimientoPendienteDTO $dto): bool{
       return $movimientoPendiente->update($dto->toArray());
    }

}
