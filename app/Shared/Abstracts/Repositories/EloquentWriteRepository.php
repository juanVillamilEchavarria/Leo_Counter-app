<?php

namespace App\Shared\Abstracts\Repositories;

use App\Shared\Contracts\DTOs\DTOContract;
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
 * @package App\Shared\Abstracts\Repositories
 * @since 1.0.0
 */
abstract class EloquentWriteRepository {

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
     * Funcion que se encarga de crear un nuevo registro en la base de datos, recibe un DTO con los datos necesarios para crear el registro, y devuelve el modelo creado
      * @param DTOContract $dto
     * @return Model
     */
    public function store ( DTOContract $dto): Model{
        return $this->create($dto->toArray());
    }
    /**
     * Funcion que se encarga de actualizar un registro en la base de datos, recibe el modelo a actualizar y un DTO con los datos necesarios para actualizar el registro, devuelve un booleano indicando si la actualizacion fue exitosa o no
      * @param Model $model
      * @param DTOContract $dto
     * @return bool
     */

    public function update( Model $model, DTOContract $dto) : bool{
        return $model->update($dto->toArray());
    }
    /**
     * Funcion que se encarga de cambiar el valor de un atributo booleano en la base de datos
      * @param Model $model
      * @param string $attribute
     * @return bool
     */
    public function toggle(Model $model, string $attribute): bool{
        $this->validateToggleAttribute($model, $attribute);
        return $model->update([$attribute => !$model->$attribute]);
    }

    /**
     * Funcion que se encarga de eliminar un registro en la base de datos, o si esta declarado como soft delete, recibe el modelo a eliminar, devuelve un booleano indicando si la eliminacion fue exitosa o no
      * @param Model $model
     * @return bool
     */
    public function destroy(Model $model): bool{
        return $model->delete();
    }

    /**
     * Funcion que se encarga de eliminar un registro de forma permanente en la base de datos, recibe el modelo a eliminar, devuelve un booleano indicando si la eliminacion fue exitosa o no
      * @param Model $model
     * @return bool
     */
    public function hardDelete(Model $model): bool{
        return $model->forceDelete();
    }
    /**
     * Funcion que se encarga de crear un nuevo registro en la base de datos, recibe un array con los datos necesarios para crear el registro, y devuelve el modelo creado
      * @param array<string, mixed> $data
     * @return Model
     */
    protected function create ( array $data): Model{
        return ($this->model)::create($data);
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