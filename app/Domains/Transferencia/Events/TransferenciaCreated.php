<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Transferencia\Events;

use App\Domains\Transferencia\Aggregates\Transferencia;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de transferencia creada
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final readonly class TransferenciaCreated implements EventContract
{
    public function __construct(
        private Transferencia $transferencia,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }
    public function getTransferencia(): Transferencia
    {
        return $this->transferencia;
    }
    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
