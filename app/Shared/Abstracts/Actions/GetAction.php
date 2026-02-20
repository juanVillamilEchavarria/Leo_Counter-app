<?php

namespace App\Shared\Abstracts\Actions;

use App\Shared\Contracts\Actions\GetActionContract;
use Illuminate\Database\Eloquent\Model;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\Shared\Abstracts\Actions\Action;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

abstract class GetAction extends Action implements GetActionContract{
    protected array $relations = [];

    protected array $searchColumns = [];

    protected array $relationsColumns= [];
    protected  ?LengthAwarePaginator $paginator = null ;
    protected function allDetails(): Builder{
        return $this->model::query()->with($this->relations);
    }
    // funcion para sobreescribir en caso de que se necesite cargar relaciones adicionales
    protected function getDetailsRelations(): array{
        return $this->relations;
    }

    protected function getSearchColumns(): array{
        return $this->searchColumns;
    }

    protected function getRelationsColumns(): array{
        return $this->relationsColumns;
    }

    protected function getSearchQuery(Builder $query, array $searchColumns, string $search): Builder{
        $query->where(function ($query) use ($searchColumns, $search) {
              $query->where(Arr::first($this->searchColumns), 'like', "%$search%");
            foreach ($searchColumns as $column => $value) {
                if(is_array($value)){
                    $query->orWhereHas($column, function ($query) use ($search, $value) {
                        foreach($value as $column){
                            $query->where($column, 'like', "%$search%");
                        }
                    });
                }else{
                    $query->orWhere($value, 'like', "%$search%");
                }
            }
        });
        
        return $query;
    }

    public function getPaginator(){
        return $this->paginator;
    }
    public function setPaginator(LengthAwarePaginator $paginator){
        $this->paginator = $paginator;
    }

    public function getPaginatedQuery ( TableQueryDTO $dto, ?Builder $query = null){
        $query === null && $query = $this->allDetails();
        if(!empty($dto->search)){
            $query = $this->getSearchQuery($query, $this->getSearchColumns(), $dto->search);
        }
        if(!empty($dto->sortBy) && !empty($dto->sortOrder)){
            if(array_key_exists($dto->sortBy, $this->getRelationsColumns())){
                $relationData = $this->getRelationsColumns()[$dto->sortBy];
                $relation = $relationData['relation'];
                $column = $relationData['column'];
                $relationInstance = $this->model::query()->getModel()->{$relation}();

                $relatedTable = $relationInstance->getRelated()->getTable();
                $foreignKey = $relationInstance->getQualifiedForeignKeyName();
                $ownerKey = $relationInstance->getQualifiedOwnerKeyName();
                $query->leftJoin($relatedTable, $foreignKey, '=', $ownerKey)
                        ->orderBy($column, $dto->sortOrder)
                        ->select($this->model::query()->getModel()->getTable().'.*');
            }else{
              $query->orderBy($dto->sortBy, $dto->sortOrder);
            }
        }
        $dto->perPage && $this->setPaginator($query->paginate($dto->perPage));
        return $query;
    }
    

    public function allPaginated(TableQueryDTO $dto, array $initialWheres = []){
        $query = $this->allDetails();
        if(!empty($initialWheres)){
            $query = $this->iteratorWheres($query, $initialWheres);
        }
        return $this->getPaginatedQuery($dto, $query);
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
        $data =$this->allDetails()->orderBy('id', 'asc');
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