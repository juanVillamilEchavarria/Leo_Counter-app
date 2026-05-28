<?php

namespace App\Application\MovimientoPendiente\Commands\Handlers;

use App\Application\MovimientoPendiente\Commands\UpdateMovimientoPendienteCommand;
use App\Application\MovimientoPendiente\Exceptions\CannotFindMovimientoPendienteException;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

/**
 * Handler del comando UpdateMovimientoPendienteCommand.
 * Recupera el agregado desde el repositorio, aplica las reglas de actualizacion
 * mediante el metodo updateData del agregado y persiste el nuevo estado inmutable.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateMovimientoPendienteHandler
{
    public function __construct(
        private MovimientoPendienteRepositoryContract $repository,
    ) {
    }

    public function __invoke(UpdateMovimientoPendienteCommand $command): bool
    {
        $aggregate = $this->repository->findById(new MovimientoPendienteId($command->id));
        if (!$aggregate) {
            throw new CannotFindMovimientoPendienteException();
        }
        assert($aggregate instanceof MovimientoPendiente);

        $updated = $aggregate->updateData(
            categoria_id: new CategoriaId($command->categoria_id),
            cuenta_id: new CuentaId($command->cuenta_id),
            tipo_movimiento_id: TipoMovimientoEnum::try($command->tipo_movimiento_id),
            nombre: $command->nombre,
            monto: new Amount($command->monto),
            fecha_programada: new Date(new DateTimeImmutable($command->fecha_programada)),
            dias_aviso: $command->dias_aviso,
            descripcion: $command->descripcion,
        );

        return $this->repository->update($updated);
    }
}
