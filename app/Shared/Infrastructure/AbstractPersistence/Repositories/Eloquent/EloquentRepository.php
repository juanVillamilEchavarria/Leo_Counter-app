<?php

namespace App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent;

use App\Models\Cuenta\Cuenta;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Exceptions\InvalidToggleAttributeException;
/**
 * Repositorio base para operaciones de escritura usando Eloquent.
 *
 * Este repositorio abstrae las operaciones comunes:
 * - almacenamiento de nuevos registros
 * - actualización de registros existentes
 * - eliminación de registros (soft delete y hard delete)
 *
 * No gestiona operaciones de lectura; para eso existe EloquentReadRepository.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent
 * @since 1.0.0
 */
abstract class EloquentRepository {

    /**
     * Array con los atributos permitidos para ser toggeados
     * Formato : ['attribute1', 'attribute2']
     * @var array<string>
     * @example ['active', 'registrar_automatico']
     */
    protected array $toggeable = [];
    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }

    /**
     * Convierte un agregado de dominio en un array asociativo de atributos para ser persistidos en la base de datos.
     * @param object $aggregate
     * @return array
     */
    abstract protected function mapAggregateToAttributes(object $aggregate): array;
    /**
     * Convierte un modelo de Eloquent en un agregado de dominio.
     * @param Model $model
     * @return AggregateModelContract
     */

    abstract protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract;

    /**
     * Funcion que se encarga de crear un nuevo registro en la base de datos, recibe un DTO con los datos necesarios para crear el registro, y devuelve el modelo creado
      * @param AggregateModelContract $aggregate
     * @return AggregateModelContract
     */
    public function store ( AggregateModelContract $aggregate): AggregateModelContract{
        $record = $this->create($this->mapAggregateToAttributes($aggregate));
        return $this->mapDatabaseRecordToAggregate($record);
    }
    /**
     * Funcion que se encarga de actualizar un registro en la base de datos, recibe el modelo a actualizar y un DTO con los datos necesarios para actualizar el registro, devuelve un booleano indicando si la actualizacion fue exitosa o no
      * @param AggregateModelContract $aggregate
     * @return bool
     */

    public function update( AggregateModelContract $aggregate) : bool{
        $model = ($this->model)::find($this->normalizeId($aggregate->getId()));
        if (!$model) {
            return false;
        }
        return $model->update($this->mapAggregateToAttributes($aggregate));
    }
    /**
     * Funcion que se encarga de cambiar el valor de un atributo booleano en la base de datos
      * @param AggregateModelIdContract $id El ID de la categoría a la que se le va a alternar el valor del atributo
      * @param string $attribute
     * @return bool
     */
    public function toggle(AggregateModelIdContract $id, string $attribute): bool{
        $model = ($this->model)::find($this->normalizeId($id));
        if (!$model) {
            return false;
        }
        $this->validateToggleAttribute($model, $attribute);
        return $model->update([$attribute => !$model->$attribute]);
    }

    /**
     * Funcion que se encarga de eliminar un registro en la base de datos, o si esta declarado como soft delete, recibe el modelo a eliminar, devuelve un booleano indicando si la eliminacion fue exitosa o no
      * @param AggregateModelIdContract $id
     * @return bool
     */
    public function destroy(AggregateModelIdContract $id): bool{
        $model = ($this->model)::find($this->normalizeId($id));
        return $model ? $model->delete() : false;
    }

    /**
     * Obtiene un registro por ID
     * @param AggregateModelIdContract $id
     * @return AggregateModelContract|null
     */
    public function findById(AggregateModelIdContract $id): ?AggregateModelContract{
        $model = ($this->model)::find($this->normalizeId($id));
        return $model ? $this->mapDatabaseRecordToAggregate($model) : null;
    }

    /**
     * Obtiene un registro eliminado por ID
     * @param AggregateModelIdContract $id
     * @return AggregateModelContract|null
     */
    public function findByIdWithTrashed(AggregateModelIdContract $id): ?AggregateModelContract{
        $model = ($this->model)::withTrashed()->find($this->normalizeId($id));
        return $model ? $this->mapDatabaseRecordToAggregate($model) : null;
    }
    /**
     * Funcion para restaurar un registro eliminado de la base de datos
     * @param AggregateModelIdContract $id
     * @return bool
     */

    public function restore(AggregateModelIdContract $id) : bool{
        $model = ($this->model)::withTrashed()->find($this->normalizeId($id));
        return $model ? $model->restore() : false;
    }

    /**
     * Funcion que se encarga de eliminar un registro de forma permanente en la base de datos, recibe el modelo a eliminar, devuelve un booleano indicando si la eliminacion fue exitosa o no
      * @param AggregateModelIdContract $id
     * @return bool
     */
    public function hardDelete(AggregateModelIdContract $id): bool{
        $model = ($this->model)::withTrashed()->find($this->normalizeId($id));
        return $model ? $model->forceDelete() : false;
    }
    /**
     * Funcion que se encarga de crear un nuevo registro en la base de datos, recibe un array con los datos necesarios para crear el registro, y devuelve el modelo creado
      * @param array<string, mixed> $data
     * @return Model
     */
    protected function create ( array $data): Model{
        return ($this->model)::create($data);
    }

    private function normalizeId(AggregateModelIdContract $id): string
    {
        return $id->getValue();
    }

    private function validateToggleAttribute(Model $model, string $attribute): void{
        if(!in_array($attribute, $this->toggeable)){
            throw new InvalidToggleAttributeException("El atributo $attribute no es togggeable");
        }
        if(!is_bool($model->$attribute)){
            throw new InvalidToggleAttributeException("El atributo $attribute no es booleano");
        }
        if(!array_key_exists($attribute, $model->getAttributes())){
            throw new InvalidToggleAttributeException("El atributo $attribute no existe en el modelo");
        }
    }
}
