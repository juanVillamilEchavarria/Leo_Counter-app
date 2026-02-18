<?php

namespace App\Shared\Abstracts\Actions;

use App\Shared\Contracts\Actions\GetActionContract;
use Illuminate\Database\Eloquent\Model;
use App\Shared\DTOs\WhereFilterQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use App\Shared\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

abstract class GetAction extends Action implements GetActionContract{
    protected array $relations = [];
    protected function allDetails(): Builder{
        return $this->model::query()->with($this->relations);
    }
    // funcion para sobreescribir en caso de que se necesite cargar relaciones adicionales
    protected function getDetailsRelations(): array{
        return $this->relations;
    }

    protected function iteratorWheres($data, array $wheres): Builder{
        /** @var WhereFilterQueryDTO[] $wheres */
        foreach($wheres as $where){
            $data->where($where->column, $where->operator->value, $where->value, $where->logic);
        }
        return $data;
    }

    public function getAllWithDetails(): Collection{
        return $this->allDetails()->get();
    }

    public function getAllWithDetailsWhere(array $wheres): Collection{
        $data =$this->allDetails();
        return $this->iteratorWheres($data, $wheres)->get();
    }
    public function getWithDetails(Model $model): Model{
        return $model->load($this->getDetailsRelations());
    }

    public function where(array $wheres): Builder{
        $data = $this->model::query();
        return $this->iteratorWheres($data, $wheres);
    }

    public function firstOrFail(array $wheres): Model{
        return $this->where($wheres)->firstOrFail();
    }
    public function find(int $id){
        return $this->model::find($id);
    }
    public function getRecordsCount(): int{
        return $this->model::count();
    }
}