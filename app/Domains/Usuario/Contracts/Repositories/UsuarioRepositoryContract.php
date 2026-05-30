<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Usuario\Contracts\Repositories;

use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\RepositoryContract;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Contrato del repositorio de escritura para el agregado Usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface UsuarioRepositoryContract extends RepositoryContract
{
    /**
     * Busca un usuario por correo electronico y lo reconstituye como agregado.
     *
     * @param Email $email Correo electronico del usuario.
     * @return Usuario|null Usuario encontrado o null.
     */
    public function findByEmail(Email $email): ?Usuario;
}
