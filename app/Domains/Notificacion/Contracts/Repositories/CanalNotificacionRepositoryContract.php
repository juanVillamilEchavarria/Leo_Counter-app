<?php

namespace App\Domains\Notificacion\Contracts\Repositories;

use App\Domains\Notificacion\Aggregates\CanalNotificacion;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;

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
    public function findById(CanalNotificacionId $id): ?CanalNotificacion;

    public function update(CanalNotificacion $canal): bool;

    public function toggle(CanalNotificacionId $id, string $attribute): bool;
}
