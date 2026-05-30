<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Commands\Handlers;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Application\MovimientoPendiente\Commands\StoreMovimientoPendienteCommand;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use DateTimeImmutable;

/**
 * Manejador de la creación de un movimiento pendiente.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Commands\Handlers
 * @version 1.0.0
 * @since 1.0.0
 *
 */
final readonly class StoreMovimientoPendienteHandler
{

    public function __construct(
        private MovimientoPendienteRepositoryContract $movimientoPendienteRepository,
        private IdGeneratorContract $idGenerator
    )
    {
    }

    public function __invoke(StoreMovimientoPendienteCommand $command): MovimientoPendiente
    {
        $movimientoPendiente = MovimientoPendiente::create(
            id: MovimientoPendienteId::generate($this->idGenerator),
            categoria_id: new CategoriaId($command->categoria_id),
            cuenta_id: new CuentaId($command->cuenta_id),
            tipo_movimiento_id: TipoMovimientoEnum::try($command->tipo_movimiento_id),
            nombre: $command->nombre,
            monto: new Amount($command->monto),
            fecha_programada: new Date(new DateTimeImmutable($command->fecha_programada)),
            dias_aviso: $command->dias_aviso,
            descripcion: $command->descripcion
        );

        /**
         * @var MovimientoPendiente
         */
        return $this->movimientoPendienteRepository->store($movimientoPendiente);

    }
}
