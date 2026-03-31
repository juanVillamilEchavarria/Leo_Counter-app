<?php

namespace App\Domains\Cuenta\Repositories\Contracts;

use App\Models\Cuenta\Cuenta;
use App\Shared\Contracts\DTOs\DTOContract;
use Illuminate\Database\Eloquent\Model;

interface CuentaWriteRepositoryContract{
    public function store(DTOContract $storeCuentaDTO);
    public function update(Model $cuenta, DTOContract $updateCuentaDTO): bool;
    public function destroy(Model $cuenta): bool;
    public function toggle(Model $cuenta, string $attribute): bool;
}
