<?php

namespace App\Application\Propietario\Queries\Handlers;

use App\Application\Propietario\Queries\GetPropietarioForEditQuery;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Application\Propietario\DTOs\PropietarioEditDTO;
use App\Domains\Propietario\Exceptions\CannotFindPropietarioException;
use App\Domains\Propietario\ValueObjects\PropietarioId;
/**
 * Handler que maneja la consulta para obtener un propietario específico.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetPropietarioForEditHandler
{
    public function __construct(
        private PropietarioRepositoryContract $repository,

    ) {}

    public function __invoke(GetPropietarioForEditQuery $query)
    {
        $existing= $this->repository->findById(new PropietarioId($query->id));
        if(!$existing){
            throw new CannotFindPropietarioException();
        }
        return new PropietarioEditDTO(
            id: $query->id,
            nombre: $existing->getNombre(),
            apellido: $existing->getApellido(),
            telefono: $existing->getTelefono(),
            email: $existing->getEmail()->__toString()
        );
    }
}
