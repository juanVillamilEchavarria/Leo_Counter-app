<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\ValueObjects;

use DateTimeImmutable;
use DateInterval;

/**
 * Valor objeto que representa una fecha.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class  Date{
    public function __construct(
        private DateTimeImmutable $date
    )
    {
    }


    /**
     * Devuelve la fecha en el formato especificado.
     * @param string $format
     * @return string
     */

    public function format(string $format = 'Y-m-d'): string{
        return $this->date->format($format);
    }

    /**
     * Suma un número de meses a la fecha.
     * @param string $months - Cantidad de meses a sumar
     * @return self - Fecha resultante
     * @throws \Exception
     */
    public function addMonths(string $months = '1'): self{
        return new self (
            date: $this->date->add(new \DateInterval('P' . $months . 'M'))
        );
    }

    /**
     * Añade un numero de semanas a la fecha
     * @param string $weeks
     * @return self
     * @throws \Exception
     */
    public function addWeeks(string $weeks = '1'): self{
        return new self (
            date: $this->date->add(new \DateInterval('P' . $weeks . 'W'))
        );
    }

    /**
     * Añade un numero de años a la fecha
     * @param string $years
     * @return self
     * @throws \Exception
     */

    public function addYears(string $years = '1'): self{
        return new self (
            date: $this->date->add(new \DateInterval('P' . $years . 'Y'))
        );
    }

    /**
     * Suma un numero de dias a la fecha
     * @param string $days - Cantidad de dias a sumar
     * @return self - fecha resultante
     * @throws \Exception
     */
    public function addDays(string $days = '1'): self{
        return new self (
            date: $this->date->add(new \DateInterval('P' . $days . 'D'))
        );
    }

    public function getPeriod(): DateTimeImmutable
    {
        return $this->date;
    }

}
