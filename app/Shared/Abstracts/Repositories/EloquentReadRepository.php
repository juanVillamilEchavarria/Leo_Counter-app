<?php

namespace App\Shared\Abstracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Collection;

abstract class EloquentReadRepository{
    /**
     * Configuracion de $relations
     * Formato : ['relationName']
     */
    protected array $relations = [];
    /**
     * Configuracion de $searchColumns
     * 
     * Formato: ['column_name' => 'column_name', 'relation_name' => ['relation.column']]
     */
    protected array $searchColumns = [];

    /**
     * Configuracion de $sortableRelations
     * 
     * Formato: ['sortKey' => ['relation' => 'relationName', 'column' => 'table.column']]
     */

    protected array $sortableRelations= [];


    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }


    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator{
        $query = $this->queryWithRelations();
        if(!empty($initialWheres)){
            $query = $this->applyWheres($query, $initialWheres);
        }
        
        return $this->applyPaginate($dto, $query);
    }

   
    public function getAll(): Collection{
        return $this->model::all();
    }

    public function getAllWithDetails(): Collection{
        return $this->queryWithRelations()->get();
    }

    public function getAllWithDetailsWhere(array $wheres): Collection{
        $data =$this->queryWithRelations()->orderBy('id', 'asc');
        return $this->applyWheres($data, $wheres)->get();
    }
    public function getWithDetails(Model $model): Model{
        return $model->load($this->getDetailsRelations());
    }

    public function where(array $wheres): Builder{
        $data = $this->model::query();
        return $this->applyWheres($data, $wheres);
    }

    public function whereAttr(string $attribute, $value): Builder{
        return $this->model::query()->where($attribute, $value);
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
    protected function queryWithRelations(): Builder{
        return $this->model::query()->with($this->relations);
    }
    // funciones para sobreescribir en caso de que se necesite cargar relaciones adicionales
    protected function getDetailsRelations(): array{
        return $this->relations;
    }

    protected function getSearchColumns(): array{
        return $this->searchColumns;
    }

    protected function getSortableRelations(): array{
        return $this->sortableRelations;
    }


    protected function applySearch(Builder $query, array $searchColumns, string $search): Builder{
        $query->where(function ($query) use ($searchColumns, $search) {
            $isFirst = true;
            foreach ($searchColumns as $relation => $column) {
                   $query= is_array($column)?
                    $this->applyRelationSearch($query, $relation, $column, $search, $isFirst) :
                    $this->applyColumnSearch($query, $column, $search, $isFirst);
                $isFirst = false;
            }
        });
      
        return $query;
    }

    private function applyColumnSearch(Builder $query, string $column, string $search, bool $isFirst): Builder{
        return $isFirst ? 
        $query->where($column, 'like', "%$search%") : 
        $query->orWhere($column, 'like', "%$search%");
    }
    private function applyRelationSearch(Builder $query, string $relation, array $columns, string $search, bool $isFirst): Builder{
        $method = $isFirst ? 'whereHas' : 'orWhereHas';
        return $query->{$method}($relation, function ($q) use ($columns, $search) {
                $q->where(function ($subQuery) use ($columns, $search) {
                    $first = true;
                    foreach ($columns as $column) {
                        if ($first) {
                            $subQuery->where($column, 'like', "%$search%");
                            $first = false;
                        } else {
                            $subQuery->orWhere($column, 'like', "%$search%");
                        }
                    }
                });
            });
    }



    protected function applyPaginate ( TableQueryDTO $dto, ?Builder $query = null): LengthAwarePaginator{
        $query === null && $query = $this->queryWithRelations();
        if(!empty($dto->search)){
            $query = $this->applySearch($query, $this->getSearchColumns(), $dto->search);
        }
        if(!empty($dto->sortBy) && !empty($dto->sortOrder)){
            if(array_key_exists($dto->sortBy, $this->getSortableRelations())){
                $this->executeOrderQueryWithRelations($dto, $query);
            }else{
              $query->orderBy($dto->sortBy, $dto->sortOrder);
            }
        }
        return $query->paginate($dto->perPage);
        
    }

    protected function applySort(TableQueryDTO $dto, Builder $query){
        if(array_key_exists($dto->sortBy, $this->getSortableRelations())){
            return $this->executeOrderQueryWithRelations($dto, $query);
        }
        return $query->orderBy($dto->sortBy, $dto->sortOrder);
    }
     protected function applyWheres(Builder $query, array $wheres): Builder{
        /** @var WhereFilterQueryDTO[] $wheres */
        foreach($wheres as $where){
            $query->where($where->column, $where->operator->value, $where->value, $where->logic);
        }
        return $query;
    }
    private function executeOrderQueryWithRelations (TableQueryDTO $dto, Builder $query): void{
        $relationData = $this->getSortableRelations()[$dto->sortBy];
            $relation = $relationData['relation'];
            $column = $relationData['column'];
            $relationInstance = $this->model::query()->getModel()->{$relation}();
            $relatedTable = $relationInstance->getRelated()->getTable();
            $foreignKey = $relationInstance->getQualifiedForeignKeyName();
            $ownerKey = $relationInstance->getQualifiedOwnerKeyName();
            $query->leftJoin($relatedTable, $foreignKey, '=', $ownerKey)
                    ->orderBy($column, $dto->sortOrder)
                    ->select($this->model::query()->getModel()->getTable().'.*');
    }
}