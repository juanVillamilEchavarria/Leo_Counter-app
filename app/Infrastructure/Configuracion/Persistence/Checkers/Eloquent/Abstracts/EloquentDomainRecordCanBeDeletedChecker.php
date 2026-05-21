<?php

namespace App\Infrastructure\Configuracion\Persistence\Checkers\Eloquent\Abstracts;

use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use Illuminate\Database\Eloquent\Model;

abstract readonly class EloquentDomainRecordCanBeDeletedChecker implements DomainRecordCanBeDeletedCheckerContract
{
    /**
     * @param class-string<Model> $model
     */
    public function __construct(
        protected string $model
    ){}

    /**
     * Devuelve las relaciones asociadas al modelo
     * @return array
     */
    abstract protected function relations(): array;

    /**
     * @inheritDoc
     */
    public function canBeDeleted(AggregateModelIdContract $id): bool
    {
        $model = $this->model::withTrashed()->find($id->getValue());
        if(!$model) throw new \RuntimeException('El registro no existe');
        foreach($this->relations() as $relation){
            if(!method_exists($model, $relation)){
                continue;
            }
            if($model->$relation()->exists()){
                return false;
            }
        }
        return true;
    }
}
