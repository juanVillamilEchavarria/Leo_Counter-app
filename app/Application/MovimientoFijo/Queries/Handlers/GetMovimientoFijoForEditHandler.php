<?php

namespace App\Application\MovimientoFijo\Queries\Handlers;

use App\Application\MovimientoFijo\DTOs\MovimientoFijoEditDTO;
use App\Application\MovimientoFijo\Exceptions\CannotFindMovimientoFijoException;
use App\Application\MovimientoFijo\Queries\GetMovimientoFijoForEditQuery;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;

/**
 * Handler encargado de obtener los datos de un movimiento fijo para edicion.
 * Recupera el agregado desde el repositorio y lo transforma en un DTO de presentacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoFijoForEditHandler
{
    public function __construct(
        private MovimientoFijoRepositoryContract $repository,
    ) {
    }

    public function __invoke(GetMovimientoFijoForEditQuery $query): MovimientoFijoEditDTO
    {
        $aggregate = $this->repository->findById(new MovimientoFijoId($query->id));
        if (!$aggregate) {
            throw new CannotFindMovimientoFijoException();
        }
        assert($aggregate instanceof MovimientoFijo);

        return new MovimientoFijoEditDTO(
            id: $aggregate->getId()->getValue(),
            categoria_id: $aggregate->getCategoriaId()->getValue(),
            tipo_movimiento_id: $aggregate->getTipoMovimientoId(),
            cuenta_id: $aggregate->getCuentaId()->getValue(),
            frecuencia_movimiento_id: $aggregate->getFrecuenciaMovimientoId(),
            nombre: $aggregate->getNombre(),
            monto: $aggregate->getMonto(),
            fecha_proximo: $aggregate->getFechaProximo()->format('Y-m-d'),
            dias_aviso: $aggregate->getDiasAviso(),
            descripcion: $aggregate->getDescripcion(),
            active: $aggregate->getActive(),
            registrar_automatico: $aggregate->getRegistrarAutomatico(),
        );
    }
}
