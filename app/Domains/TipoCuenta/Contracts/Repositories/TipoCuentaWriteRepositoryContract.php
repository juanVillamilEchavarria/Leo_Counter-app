<?php

namespace App\Domains\TipoCuenta\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface TipoCuentaWriteRepositoryContract
{
    public function store(DTOContract $storeTipoCuentaDTO);
    public function update(Model $tipoCuenta, DTOContract $updateTipoCuentaDTO): bool;
    public function destroy(Model $tipoCuenta): bool;
}
