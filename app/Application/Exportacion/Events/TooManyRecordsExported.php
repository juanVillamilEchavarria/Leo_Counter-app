<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Events;

use App\Shared\Domain\Contracts\EventContract;
use App\Domains\Exportacion\Aggregate\Exportacion;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;
use Override;

final readonly class TooManyRecordsExported implements EventContract{
    public function __construct(
        private readonly Exportacion $exportacion,
        private readonly Date $ocurredOn = new Date(new DateTimeImmutable())
    )
    {
    }

    public function getExportacion(): Exportacion
    {
        return $this->exportacion;
    }
    #[Override]
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }

}