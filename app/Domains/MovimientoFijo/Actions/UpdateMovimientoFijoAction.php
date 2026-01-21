<?php

namespace App\Domains\MovimientoFijo\Actions;

use App\Models\MovimientoFijo\MovimientoFijo;
use App\Domains\MovimientoFijo\DTOs\UpdateMovimientoFijoDTO;

use App\Domains\MovimientoFijo\Exceptions\CannotUpdateMovimientoFijoException;
class UpdateMovimientoFijoAction{

    public function update(MovimientoFijo $movimientoFijo, UpdateMovimientoFijoDTO $dto){
        $movimientoFijo->update($dto->toArray());

    }
    public function toggleActive(MovimientoFijo $movimientoFijo): bool{
        if(!$movimientoFijo){
            throw new CannotUpdateMovimientoFijoException;
        }
        return $movimientoFijo->update(['active' => !$movimientoFijo->active]);
        
    }

    public function toggleRegistrarAutomatico(MovimientoFijo $movimientoFijo): bool{
        if(!$movimientoFijo){
            throw new CannotUpdateMovimientoFijoException;
        }
        return $movimientoFijo->update(['registrar_automatico' => !$movimientoFijo->registrar_automatico]);
        
    }
}