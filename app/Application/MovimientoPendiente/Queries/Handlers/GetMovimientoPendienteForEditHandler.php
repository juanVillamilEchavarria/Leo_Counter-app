<?php

namespace App\Application\MovimientoPendiente\Queries\Handlers;

use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteEditDTO;
use App\Application\MovimientoPendiente\Exceptions\CannotFindMovimientoPendienteException;
use App\Application\MovimientoPendiente\Queries\GetMovimientoPendienteForEditQuery;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;

/**
 * Handler encargado de obtener los datos de un movimiento pendiente para edicion.
 * Recupera el agregado desde el repositorio y lo transforma en un DTO de presentacion
 * con tipos primitivos para ser consumido por la capa de presentacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoPendienteForEditHandler
{
    public function __construct(
        private MovimientoPendienteRepositoryContract $repository,
    ) {
    }

    public function __invoke(GetMovimientoPendienteForEditQuery $query): MovimientoPendienteEditDTO
    {
        $aggregate = $this->repository->findById(new MovimientoPendienteId($query->id));
        if (!$aggregate) {
            throw new CannotFindMovimientoPendienteException();
        }
        assert($aggregate instanceof MovimientoPendiente);

        return new MovimientoPendienteEditDTO(
            id: $aggregate->getId()->getValue(),
            categoria_id: $aggregate->getCategoriaId()->getValue(),
            cuenta_id: $aggregate->getCuentaId()->getValue(),
            tipo_movimiento_id: $aggregate->getTipoMovimientoId(),
            nombre: $aggregate->getNombre(),
            monto: $aggregate->getMonto(),
            fecha_programada: $aggregate->getFechaProgramada()->format('Y-m-d'),
            dias_aviso: $aggregate->getDiasAviso(),
            descripcion: $aggregate->getDescripcion(),
            estado: $aggregate->getEstado()->value,
        );
    }
}
