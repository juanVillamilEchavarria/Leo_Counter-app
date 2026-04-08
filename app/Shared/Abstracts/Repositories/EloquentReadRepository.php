<?php

namespace App\Shared\Abstracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repositorio base para operaciones de lectura usando Eloquent.
 *
 * Este repositorio abstrae las consultas comunes:
 * - paginación
 * - ordenamiento
 * - búsqueda por columnas
 * - carga de relaciones
 *
 * No gestiona operaciones de escritura; para eso existe EloquentWriteRepository.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Abstracts\Repositories
 * @since 1.0.0
 */

abstract class EloquentReadRepository{ 
    /**
     * Configuracion de $relations
     * Relaciones que se pueden cargar con los registros de la tabla, estas relaciones se cargaran en las consultas que lo requieran, como getWithDetails, getAllWithDetails, etc
     * Formato : ['relationName']
     * @var array<string>
     */
    protected array $relations = [];
    /**
     * Columnas de búsqueda permitidas.
     *
     * Formato:
     * [
     *   'column' => 'column',
     *   'relation' => ['relation.column']
     * ]
     *
     * @var array<string, string|array<int, string>>
     */
    protected array $searchColumns = [];

    /**
     * Configuracion de $sortableRelations
     * campos de relacion con otras tablas los cuales pueden ser ordenados en la tabla
     * 
     * Formato: [
        * 'sortKey' => [
        *   'relation' => 'relationName',
        *   'column' => 'table.column'
     *      ]
     *  ]
     * @var array<array<string>>
     */

    protected array $sortableRelations= [];
    /**
     * Configuracion de $forOptionsColumns
     * Formato : ['column_name']
     * @var array<string>
     */

    protected array $forOptionsColumns = [];


    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }
    /**
     * Devuelve el modelo asociado al repositorio
     */
    public function getModel(): string{
        return $this->model;
    }

    /**
     * Verifica si el modelo tiene registros en las tablas relacionadas
     * @return bool
     */
    public function hasRelationsRecords(Model $model): bool{
        foreach($this->relations as $relation){
            
            if(!method_exists($model, $relation)){
                continue;
            }
           if($model->$relation()->exists()){
               return true;
           }
        }
        return false;
    }
    /**
     * Devuelve los datos necesarios del modelo para mostrarlo como una opcion en un formulario o en un select
     * @return Collection<Model>
     */

    public function getForOptions(): Collection{
        return $this->model::query()->select($this->forOptionsColumns)->get();
    }

    /**
     * Funcion que se encarga de hacer la filtracion entera de la tabla (busqueda, ordenamiento y paginacion)
     * @param TableQueryDTO $dto
     * @param WhereQueryFilterDTO[] $initialWheres
     * @return LengthAwarePaginator
     */

    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator{
        $query = $this->queryWithRelations();
        if(!empty($initialWheres)){
            $query = $this->applyWheres($query, $initialWheres);
        }
        
        return $this->applyPaginate($dto, $query);
    }

   
    /**
     * Obtiene todos los registros de la tabla sin relaciones ni filtros
     * @return Collection<Model>
     */
    public function getAll(): Collection{
        return $this->model::all();
    }
    /**
     * Obtiene todos los registros de la tabla sin relaciones ni filtros
     * @return Collection<Model>
     */
    public function getAllDeleted(): Collection{
        return $this->model::onlyTrashed()->get();
    }

    /**
     * Obtiene todos los registros con las relaciones declaradas 
     * @return Collection<Model>
     */
    public function getAllWithDetails(): Collection{
        return $this->queryWithRelations()->get();
    }

    /**
     * Obtiene todos los registros con las relaciones declaradas y las filtra con un array de wheres
     * @param array<int | WhereQueryFilterDTO> $wheres
     * @return Collection<Model>
     */
    public function getAllWithDetailsWhere(array $wheres): Collection{
        $data =$this->queryWithRelations()->orderBy('id', 'asc');
        return $this->applyWheres($data, $wheres)->get();
    }
    /**
     * Obtiene un registro con las relaciones declaradas, el modelo debe ser instanciado
     * @param Model $model
     * @return Model
     */
    public function getWithDetails(Model $model): Model{
        return $model->load($this->getDetailsRelations());
    }

    /**
     * Aplica un array de wheres
     * @param WhereQueryFilterDTO[] $wheres
     * @return Builder<Model>
     */
    public function where(array $wheres): Builder{
        $data = $this->model::query();
        return $this->applyWheres($data, $wheres);
    }
    /**
     * Aplica un where
     * @return Builder<Model>
     */
    public function whereAttr(string $attribute, $value): Builder{
        return $this->model::query()->where($attribute, $value);
    }

    /**
     * Obtiene el primer registro que coincida con el array de wheres, si no encuentra ninguno lanza una excepcion
      * @param WhereQueryFilterDTO[] $wheres
     * @return Model
     * @throws ModelNotFoundException
     */
    public function firstOrFail(array $wheres): Model{
        return $this->where($wheres)->firstOrFail();
    }
    /**
     * Obtiene un registro por ID.
     *
     * IMPORTANTE:
     * - Retorna null si no existe.
     * - Para lanzar excepción, usar firstOrFail().
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model{
        return $this->model::find($id);
    }

    /**
     * Obtiene un registro por ID incluyendo los registros eliminados.
     * 
     * IMPORTANTE:
     * - Retorna null si no existe.
     * - Para lanzar excepción, usar findOrFail().
     */
    public function findWithTrashed(int $id): ?Model{
        return $this->model::withTrashed()->find($id);
    }
    /**
     * Obtiene la cantidad de registros de la tabla, sin importar los filtros, ni las relaciones, ni nada, simplemente el conteo total de registros de la tabla
     * @return int
     */
    public function getRecordsCount(): int{
        return $this->model::count();
    }
    /**
     * Aplica la consulta con las relaciones
     * @return Builder<Model>
     */
    protected function queryWithRelations(): Builder{
        return $this->model::query()->with($this->getDetailsRelations());
    }
    // funciones para sobreescribir en caso de que se necesite cargar relaciones adicionales
    /**
     * Retorna las relaciones que se pueden cargar con los registros del modelo, es decir, las relaciones que se declaran en la propiedad $relations, estas relaciones se cargaran en las consultas que lo requieran, como getWithDetails, getAllWithDetails, etc
      * @return array<string>
     */
    protected function getDetailsRelations(): array{
        return $this->relations;
    }
    /**
     * Retorna las columnas que se pueden buscar en la tabla, estas columnas se declaran en la propiedad $searchColumns, estas columnas se utilizan para aplicar la busqueda de strings en la tabla
      * @return array<string|array<string>>
     */

    protected function getSearchColumns(): array{
        return $this->searchColumns;
    }

    /**
     * Retorna las relaciones que se pueden ordenar
     * @return array<string>
     */
    protected function getSortableRelations(): array{
        return $this->sortableRelations;
    }


    /**
     * Funcion que aplica la busqueda de strings en la tabla, verifica si en las columnas que debe buscar, hay un array (relaciones), si es asi, aplica la busqueda en la relacion, sino aplica la busqueda en la columna
     * @param Builder $query
     * @param array<string|array<string>> $searchColumns
     * @param string $search
     * @return Builder<Model>
     */
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

    /**
     * Funcion que aplica la consulta de busqueda en los campos normales de la tabla
     * @param Builder $query
     * @param string $column
     * @param string $search
     * @param bool $isFirst
     * @return Builder<Model>
     */
    private function applyColumnSearch(Builder $query, string $column, string $search, bool $isFirst): Builder{
        return $isFirst ? 
        $query->where($column, 'like', "%$search%") : 
        $query->orWhere($column, 'like', "%$search%");
    }
    /**
     * Funcion que aplica la consulta de busqueda en las relaciones de la tabla 
     * @param Builder $query
     * @param string $relation
     * @param array<string> $columns
     * @param string $search
     * @param bool $isFirst
     * @return Builder<Model>
     */
    private function applyRelationSearch(Builder $query, string $relation, array $columns, string $search, bool $isFirst): Builder{
        $method = $isFirst ? 'whereHas' : 'orWhereHas';
        return $query->{$method}($relation, function ($q) use ($columns, $search) {
                $q->where(function ($subQuery) use ($columns, $search) {
                    $first = true;
                    foreach ($columns as $column) {// recorre cada columna y aplica la busqueda
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



    /**
     * Funcion que se encarga de hacer la filtracion entera de la tabla (busqueda, ordenamiento y paginacion), esta funcion se utiliza en el metodo paginate, se encarga de aplicar la busqueda, el ordenamiento y la paginacion
     * @param TableQueryDTO $dto
      * @param Builder|null $query
     * @return LengthAwarePaginator
     */
    protected function applyPaginate ( TableQueryDTO $dto, ?Builder $query = null): LengthAwarePaginator{
        $query === null && $query = $this->queryWithRelations();
        if(!empty($dto->search)){
            $query = $this->applySearch($query, $this->getSearchColumns(), $dto->search);
        }
        if(!empty($dto->sortBy) && !empty($dto->sortOrder)){
           $query = $this->applySort($dto, $query);
        }
        return $query->paginate($dto->perPage);
        
    }

    /**
     * Funcion que ordena las consultas, verifica si la relacion esta declarada en las propiedades del objeto, y si es asi, aplica el ordenamiento de las relaciones, si no, aplica un ordenamiento normal
     * @param TableQueryDTO $dto
      * @param Builder $query
      * @return Builder<Model>
     */
    protected function applySort(TableQueryDTO $dto, Builder $query){
        if(array_key_exists($dto->sortBy, $this->getSortableRelations())){
            return $this->executeOrderQueryWithRelations($dto, $query);
        }
        return $query->orderBy($dto->sortBy, $dto->sortOrder);
    }
    /**
     * Funcion que aplica un array de wheres a una consulta, esta funcion se utiliza para aplicar los filtros de busqueda en la tabla, recibe un array de WhereFilterQueryDTO, y aplica cada uno de los filtros a la consulta, devuelve la consulta con los filtros aplicados
     * @param Builder $query
     * @param WhereFilterQueryDTO[] $wheres
     * @return Builder<Model>
     */
     protected function applyWheres(Builder $query, array $wheres): Builder{
        /** @var WhereFilterQueryDTO[] $wheres */
        foreach($wheres as $where){
            $query->where($where->column, $where->operator->value, $where->value, $where->logic);
        }
        return $query;
    }
    /**
     * Funcion que aplica el ordenamiento de las relaciones de la tabla y aplica la busqueda en las relaciones
     * @param TableQueryDTO $dto
     * @param Builder $query
     * @return Builder<Model>
     */
    private function executeOrderQueryWithRelations (TableQueryDTO $dto, Builder $query): Builder{
        /**
         * obtiene las relaciones declaradas como sorteables (ordenables) de la tabla
         */
        $relationData = $this->getSortableRelations()[$dto->sortBy];
        /**
         * Obtiene el nombre de la relacion
         */
            $relation = $relationData['relation'];
            /**
             * Obtiene la columna de la relacion
             */
            $column = $relationData['column'];
            $relationInstance = $this->model::query()->getModel()->{$relation}();
            // Obtiene la tabla de la relacion
            $relatedTable = $relationInstance->getRelated()->getTable();
            // obtiene la llave foranea de la relacion, de la tabla principal
            $foreignKey = $relationInstance->getQualifiedForeignKeyName();
            // Obtiene la clave propia de la relacion, es decir la llave de la tabla relacionada
            $ownerKey = $relationInstance->getQualifiedOwnerKeyName();
            return $query->leftJoin($relatedTable, $foreignKey, '=', $ownerKey)
                    ->orderBy($column, $dto->sortOrder) // ordena por la columna de la relacion y en el orden indicado
                    ->select($this->model::query()->getModel()->getTable().'.*'); // selecciona todas las columnas de la tabla principal
    }
}