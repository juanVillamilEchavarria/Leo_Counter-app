<?php

namespace App\Domains\Profile\Contracts\Repositories;

use App\Shared\Contracts\DTOs\DTOContract;
use Illuminate\Database\Eloquent\Model;
interface ProfileRepositoryContract{
    public function update(Model $model,DTOContract $dto): bool;
}