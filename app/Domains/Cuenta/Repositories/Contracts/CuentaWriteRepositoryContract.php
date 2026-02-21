<?php

namespace App\Domains\Cuenta\Repositories\Contracts;

use App\Models\Cuenta\Cuenta;
use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;

interface CuentaWriteRepositoryContract{
    public function store(DTO $storeCuentaDTO);
    public function update(Model $cuenta, DTO $updateCuentaDTO): bool;
    public function destroy(Model $cuenta): bool;
    public function toggleActive(Cuenta $cuenta): bool;
}
