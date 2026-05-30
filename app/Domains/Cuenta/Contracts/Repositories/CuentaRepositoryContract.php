<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Cuenta\Contracts\Repositories;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\SoftDeleteRepositoryContract;

/**
 * Repository contract for Cuenta domain
 */
interface CuentaRepositoryContract extends SoftDeleteRepositoryContract
{
    /**
     * Store a new Cuenta
     * @param Cuenta $cuenta
     * @return AggregateModelContract
     */
    public function store(AggregateModelContract $cuenta): AggregateModelContract;

    /**
     * Update an existing Cuenta
     * @param object $cuenta
     * @param int $id
     * @return bool
     */
    public function update(AggregateModelContract $cuenta): bool;

    /**
     * Destroy a Cuenta
     * @param \App\Domains\Cuenta\ValueObjects\CuentaId $id
     * @return bool
     */
    public function destroy(AggregateModelIdContract $id): bool;

    /**
     * Toggle a boolean attribute
     * @param \App\Domains\Cuenta\ValueObjects\CuentaId $id
     * @param string $attribute
     * @return bool
     */
    public function toggle(AggregateModelIdContract $id, string $attribute): bool;

    /**
     * Find a Cuenta by ID
     * @param \App\Domains\Cuenta\ValueObjects\CuentaId $id
     * @return Cuenta|null
     */
    public function findById(AggregateModelIdContract $id): ?AggregateModelContract;
}
