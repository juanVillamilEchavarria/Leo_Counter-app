<?php

namespace App\Domains\Movimiento\Repositories\Contracts;
use App\Shared\Contracts\DTOs\DTOContract;
use Illuminate\Database\Eloquent\Model;

interface MovimientoWriteRepositoryContract
{
    public function store(DTOContract $dto);
    public function update(Model $movimiento, DTOContract $dto);
    public function destroy(Model $movimiento): bool;
}