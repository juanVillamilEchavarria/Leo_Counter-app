<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Shared\Domain\ValueObjects\Abstracts\ValueObject;
use DateInterval;
use DateTimeImmutable;
/**
 * Value Object que representa un rango de fechas
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Reporte\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final class DateRange extends ValueObject
{
    public function __construct(
        public readonly DateTimeImmutable $startDate,
        public readonly  DateTimeImmutable $endDate,
    ) {
    }

    /**
     * Obtiene la diferencia en dias entre las fechas
     * @return int
     */
    public function diffDays(): int
    {
        return (int) $this->startDate->diff($this->endDate)->days;
    }

    /**
     * Genera un nuevo DateRange equivalente al periodo anterior.
     * El periodo anterior tiene la misma duración que el actual,
     * terminando el día antes de que comience el actual.
     * @return self
     */
        public function getPreviousPeriod(): self
        {
            $duration = $this->diffDays();
            
            // El periodo anterior termina el día antes de que comience el actual
            $previousEndDate = $this->startDate->sub(new DateInterval('P1D'));
            
            // Para mantener la misma duración, restamos $duration días a la fecha de fin anterior
            $previousStartDate = $previousEndDate->sub(new DateInterval('P' . $duration . 'D'));
            
            return new self($previousStartDate, $previousEndDate);
        }

    /**
     * Genera un nuevo DateRange equivalente al periodo anterior.
     * El periodo anterior tiene la misma duración que el actual,
     * terminando el día antes de que comience el actual.
     *
     * @return self
     */
    public function toPreviousPeriod(): self
    {
        return $this->getPreviousPeriod();
    }

    /**
     * Instancia un rango de fechas con una diferencia de 6 meses
     * @return self
     */
    public static function lastSixMonths(): self
    {
        return new self(
            new DateTimeImmutable('-6 months'),
            new DateTimeImmutable()
        );
    }

    /**
     * Instancia un rango de fechas con una diferencia de 1 mes
     */
    public static function lastMonth(): self
    {
        return new self(
            new DateTimeImmutable('-1 month'),
            new DateTimeImmutable()
        );
    }

}
