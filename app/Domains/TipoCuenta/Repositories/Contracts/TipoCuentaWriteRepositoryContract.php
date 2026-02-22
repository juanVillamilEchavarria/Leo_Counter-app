<?php

namespace App\Domains\TipoCuenta\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface TipoCuentaWriteRepositoryContract
{
    public function store(DTO $storeTipoCuentaDTO);
    public function update(Model $tipoCuenta, DTO $updateTipoCuentaDTO): bool;
    public function destroy(Model $tipoCuenta): bool;
}
