<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Contracts;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
/**
 * Contrato que representa un modelo de agregado de dominio.
 * Todos los agregados deben implementar este contrato para ser reconocidos por los repositorios y servicios que trabajan con agregados.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface AggregateModelContract
{
    public function getId(): AggregateModelIdContract;
}