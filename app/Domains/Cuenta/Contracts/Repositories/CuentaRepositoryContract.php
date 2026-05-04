<?php

namespace App\Domains\Cuenta\Contracts\Repositories;

use App\Domains\Cuenta\Aggregates\Cuenta;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Repository contract for Cuenta domain
 */
interface CuentaRepositoryContract
{
    /**
     * Store a new Cuenta
     * @param Cuenta $cuenta
     * @return AggregateModelContract
     */
    public function store(object $cuenta): AggregateModelContract;

    /**
     * Update an existing Cuenta
     * @param object $cuenta
     * @param int $id
     * @return bool
     */
    public function update(object $cuenta, int $id): bool;

    /**
     * Destroy a Cuenta
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Toggle a boolean attribute
     * @param int $id
     * @param string $attribute
     * @return bool
     */
    public function toggle(int $id, string $attribute): bool;

    /**
     * Find a Cuenta by ID
     * @param int $id
     * @return Cuenta|null
     */
    public function findById(int $id): ?AggregateModelContract;
}