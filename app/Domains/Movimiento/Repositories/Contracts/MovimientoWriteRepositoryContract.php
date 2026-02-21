<?php

namespace App\Domains\Movimiento\Repositories\Contracts;
use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;

interface MovimientoWriteRepositoryContract
{
    public function store(DTO $dto);
    public function update(Model $movimiento, DTO $dto);
    public function destroy(Model $movimiento): bool;
}