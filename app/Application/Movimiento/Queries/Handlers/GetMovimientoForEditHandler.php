<?php

namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Queries\GetMovimientoForEditQuery;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Application\Movimiento\DTOs\MovimientoEditDTO;
use App\Application\Movimiento\Exceptions\CannotFindMovimientoException;
use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosForAMovimientoQueryExecutorContract;

/**
 * Handler encargado de obtener los datos necesarios para editar un movimiento.
 * Busca el agregado a través del repositorio de escritura y devuelve un DTO apto para la capa de presentación.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoForEditHandler
{
    public function __construct(
        private MovimientoRepositoryContract $repository,
        private GetAllArchivoMovimientosForAMovimientoQueryExecutorContract $getAllArchivoMovimientosForAMovimientoQueryExecutor
    ){}

    public function __invoke(GetMovimientoForEditQuery $query): MovimientoEditDTO
    {
        /** @var Movimiento $aggregate */
        $aggregate = $this->repository->findById(new MovimientoId($query->id));
        if(!$aggregate){
            throw new CannotFindMovimientoException();
        }
        $archivos = $this->getAllArchivoMovimientosForAMovimientoQueryExecutor->execute($aggregate->getId());

        return new MovimientoEditDTO(
            id: (string) $aggregate->getId(),
            nombre: $aggregate->getNombre(),
            cuenta_id: $aggregate->getCuentaId()->getValue(),
            categoria_id: $aggregate->getCategoriaId()->getValue(),
            tipo_movimiento_id: $aggregate->getTipoMovimientoId()->value,
            monto: $aggregate->getMonto()->getValue(),
            fecha: $aggregate->getFecha()->format('Y-m-d'),
            descripcion: $aggregate->getDescripcion(),
            comprobantes_existing: $archivos
        );
    }
}
