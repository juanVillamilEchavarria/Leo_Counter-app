<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Framework\Laravel\Generators;

use App\Shared\Domain\Contracts\IdGeneratorContract;
use Ramsey\Uuid\Uuid;

/**
 * Clase para la generacion de identificadores unicos utilizando UUID V7 con Ramsey.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
class LaravelIdGenerator implements IdGeneratorContract
{
    public  function generate(): string
    {
        return Uuid::uuid7()->toString();
    }
}