<?php

namespace App\Application\Presupuesto\Queries\Handlers;

use App\Application\Presupuesto\DTOs\PresupuestoEditDTO;
use App\Application\Presupuesto\Queries\GetPresupuestoForEditQuery;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Application\Presupuesto\Exceptions\CannotFindPresupuestoException;

final readonly class GetPresupuestoForEditHandler{

    public function __construct(
        private PresupuestoRepositoryContract $repository
    ){}

    public function __invoke(GetPresupuestoForEditQuery $query): PresupuestoEditDTO
    {
        $aggregate = $this->repository->findById(new PresupuestoId($query->id));
        if(!$aggregate){
            throw new CannotFindPresupuestoException();
        }
        return new PresupuestoEditDTO(
            id: $aggregate->getId(),
            categoria_id: $aggregate->getCategoriaId(),
            monto: $aggregate->getMonto(),
            descripcion: $aggregate->getDescripcion()
        );
    }
}
