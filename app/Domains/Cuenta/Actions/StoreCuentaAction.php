<?php
namespace App\Domains\Cuenta\Actions;

use App\Models\Cuenta\Cuenta;
use App\Domains\Cuenta\DTOs\StoreCuentaDTO;
use Symfony\Component\HttpKernel\HttpCache\Store;

class StoreCuentaAction
{
    public function store(StoreCuentaDTO $dto): Cuenta
    {
        return Cuenta::create($dto->toArray());
       
    }
}