<?php

namespace App\Application\MovimientoFijo\Commands\Handlers;

use App\Application\MovimientoFijo\Commands\UpdateMovimientoFijoCommand;
use App\Application\MovimientoFijo\Exceptions\CannotFindMovimientoFijoException;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\Enums\FrecuenciaMovimientoEnum;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

/**
 * Handler del comando UpdateMovimientoFijoCommand.
 * Recupera el agregado, aplica sus reglas de actualizacion y persiste el nuevo estado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateMovimientoFijoHandler
{
    public function __construct(
        private MovimientoFijoRepositoryContract $repository,
    ) {
    }

    public function __invoke(UpdateMovimientoFijoCommand $command): bool
    {
        $aggregate = $this->repository->findById(new MovimientoFijoId($command->id));
        if (!$aggregate) {
            throw new CannotFindMovimientoFijoException();
        }
        assert($aggregate instanceof MovimientoFijo);

        $updated = $aggregate->updateData(
            categoria_id: new CategoriaId($command->categoria_id),
            cuenta_id: new CuentaId($command->cuenta_id),
            tipo_movimiento_id: TipoMovimientoEnum::try($command->tipo_movimiento_id),
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::from($command->frecuencia_movimiento_id),
            nombre: $command->nombre,
            monto: new Amount($command->monto),
            fecha_proximo: new Date(new DateTimeImmutable($command->fecha_proximo)),
            dias_aviso: $command->dias_aviso,
            descripcion: $command->descripcion,
        );

        return $this->repository->update($updated);
    }
}
