<?php

namespace App\Shared\Abstracts\Repositories;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;
abstract class EloquentWriteRepository {
    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }

    public function store (DTO $dto){
        return $this->create($dto->toArray());
    }

    public function update( Model $model, DTO $dto) : bool{
        return $model->update($dto->toArray());
    }

    public function destroy(Model $model): bool{
        return $model->delete();
    }

    public function hardDelete(Model $model): bool{
        return $model->forceDelete();
    }
    protected function create ( array $data){
        return ($this->model)::create($data);
    }
}