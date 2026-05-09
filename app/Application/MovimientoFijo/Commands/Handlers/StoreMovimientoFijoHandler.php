<?php

namespace App\Application\MovimientoFijo\Commands\Handlers;

use App\Application\MovimientoFijo\Commands\StoreMovimientoFijoCommand;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

/**
 * Handler del comando StoreMovimientoFijoCommand.
 * Convierte datos primitivos en value objects, crea el agregado mediante su factoria
 * y delega la persistencia al repositorio del dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreMovimientoFijoHandler
{
    public function __construct(
        private MovimientoFijoRepositoryContract $repository,
        private IdGeneratorContract $idGenerator,
    ) {
    }

    public function __invoke(StoreMovimientoFijoCommand $command)
    {
        $movimientoFijo = MovimientoFijo::create(
            id: MovimientoFijoId::generate($this->idGenerator),
            categoria_id: new CategoriaId($command->categoria_id),
            cuenta_id: new CuentaId($command->cuenta_id),
            tipo_movimiento_id: $command->tipo_movimiento_id,
            frecuencia_movimiento_id: $command->frecuencia_movimiento_id,
            nombre: $command->nombre,
            monto: $command->monto,
            fecha_proximo: new Date(new DateTimeImmutable($command->fecha_proximo)),
            dias_aviso: $command->dias_aviso,
            descripcion: $command->descripcion,
        );

        return $this->repository->store($movimientoFijo);
    }
}
