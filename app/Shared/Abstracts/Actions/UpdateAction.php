<?php

namespace App\Shared\Abstracts\Actions;
use App\Shared\Contracts\Actions\UpdateActionContract;
use App\Shared\Abstracts\Actions\Action; 
use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;
abstract class UpdateAction extends Action implements UpdateActionContract{
    public function update( Model $model, DTO $dto) : bool
    {
        return $model->update($dto->toArray());
    }
}