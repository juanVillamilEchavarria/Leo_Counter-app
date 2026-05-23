<?php

namespace App\Domains\Notificacion\Contracts\Repositories;

use App\Domains\Notificacion\Aggregates\Canal;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Contrato del repositorio de escritura para Canales de Notificación.
 * Solo expone las operaciones necesarias: findById y update (y toggle si es requerido por infraestructura).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface CanalNotificacionRepositoryContract
{
    /**
     * @param CanalId $id
     * @return Canal|null
     */
    public function findById(AggregateModelIdContract $id): ?Canal;

    /**
     * @param Canal $canal
     * @return bool
     */
    public function update(AggregateModelContract $canal): bool;

    /**
     * @param CanalId $id
     * @param string $attribute
     * @return bool
     */
    public function toggle(AggregateModelIdContract $id, string $attribute): bool;
}
