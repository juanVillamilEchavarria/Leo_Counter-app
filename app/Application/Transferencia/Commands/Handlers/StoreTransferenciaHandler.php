<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Commands\Handlers;

use App\Application\Transferencia\Commands\StoreTransferenciaCommand;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Transferencia\Aggregates\Transferencia;
use App\Domains\Transferencia\Contracts\Repositories\TransferenciaRepositoryContract;
use App\Domains\Transferencia\ValueObjects\TransferenciaId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

/**
 * Manejador para el almacenamiento de una transferencia.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class StoreTransferenciaHandler
{
    public function __construct(
        private IdGeneratorContract $idGenerator,
        private TransferenciaRepositoryContract $transferenciaRepository
    ) {
    }

    public function __invoke(StoreTransferenciaCommand $command): void
    {
        $id = TransferenciaId::generate($this->idGenerator);

        $transferencia = Transferencia::create(
            id: $id,
            cuenta_enviadora_id: new CuentaId($command->cuenta_enviadora_id),
            cuenta_receptora_id: new CuentaId($command->cuenta_receptora_id),
            monto: new Amount($command->monto),
            fecha: new Date(new DateTimeImmutable()),
            descripcion: (string) $command->descripcion
        );

        $this->transferenciaRepository->store($transferencia);

    }
}
