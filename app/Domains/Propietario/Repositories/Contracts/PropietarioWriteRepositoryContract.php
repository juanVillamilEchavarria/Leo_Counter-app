<?php

namespace App\Domains\Propietario\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

interface PropietarioWriteRepositoryContract
{
    public function store(DTOContract $storePropietarioDTO);
    public function update(Model $propietario, DTOContract $updatePropietarioDTO): bool;
    public function destroy(Model $propietario): bool;
}
