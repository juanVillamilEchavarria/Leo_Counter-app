<?php

namespace App\Domains\Propietario\Services;

use App\Domains\Propietario\Actions\GetPropietarioAction;

class PropietarioService{
    public function __construct(
        private GetPropietarioAction $getPropietarioAction
    ){}
    public function getAll(){
        return $this->getPropietarioAction->getAll();
    }
}