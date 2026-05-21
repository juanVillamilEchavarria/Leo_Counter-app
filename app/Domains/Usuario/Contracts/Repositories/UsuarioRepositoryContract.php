<?php

namespace App\Domains\Usuario\Contracts\Repositories;

use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\ValueObjects\UsuarioId;

/**
 * Contrato del repositorio de escritura para el agregado Usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface UsuarioRepositoryContract
{
    /**
     * Busca un usuario por su identidad.
     *
     * @param UsuarioId $id Identificador del usuario.
     * @return Usuario|null
     */
    public function findById(UsuarioId $id): ?Usuario;

    /**
     * Persiste los cambios de un usuario existente.
     *
     * @param Usuario $usuario Agregado usuario.
     * @return bool
     */
    public function update(Usuario $usuario): bool;
}
