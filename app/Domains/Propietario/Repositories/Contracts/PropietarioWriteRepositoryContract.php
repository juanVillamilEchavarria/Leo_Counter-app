<?php

namespace App\Domains\Propietario\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;

interface PropietarioWriteRepositoryContract
{
    public function store(DTO $storePropietarioDTO);
    public function update(Model $propietario, DTO $updatePropietarioDTO): bool;
    public function destroy(Model $propietario): bool;
}
