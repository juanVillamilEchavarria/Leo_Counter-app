<?php

namespace App\Domains\Cuenta\Contracts\Repositories;
use App\Shared\Contracts\DTOs\DTOContract;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;


/**
 * Contrato de implementación de repositorio de escritura para el modelo Cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface CuentaRepositoryContract extends SoftDeleteRepositoryContract {
    /**
     * Guarda un nuevo registro
     * @param DTOContract $storeCuentaDTO
     * @return Model
     */
    public function store(DTOContract $storeCuentaDTO): Model;
    /**
     * Actualiza un registro existente
     * @param Model $cuenta
     * @param DTOContract $updateCuentaDTO
     * @return bool
     */
    public function update(Model $cuenta, DTOContract $updateCuentaDTO): bool;
    /**
     * Elimina un registro existente
     * @param Model $cuenta
     * @return bool
     */
    public function destroy(Model $cuenta): bool;
    /**
     * Restaura un registro eliminado
     * @param Model $cuenta
     * @return bool
     */
    public function restore(Model $cuenta): bool;
    /**
     * Alterna el valor de un atributo booleano
     * @param Model $cuenta
     * @param string $attribute
     * @return bool
     */
    public function toggle(Model $cuenta, string $attribute): bool;
}
