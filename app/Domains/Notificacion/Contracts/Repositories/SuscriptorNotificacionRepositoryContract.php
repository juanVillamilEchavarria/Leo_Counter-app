<?php

namespace App\Domains\Notificacion\Contracts\Repositories;

use App\Domains\Notificacion\Aggregates\SuscriptorNotificacion;
use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;

/**
 * Contrato del repositorio de escritura para Suscriptores de Notificación.
 * Define operaciones CRUD y toggle necesarias para el agregado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface SuscriptorNotificacionRepositoryContract
{
    public function store(SuscriptorNotificacion $suscriptor): SuscriptorNotificacion;

    public function update(SuscriptorNotificacion $suscriptor): bool;

    public function destroy(SuscriptorNotificacionId $id): bool;

    public function toggle(SuscriptorNotificacionId $id, string $attribute): bool;

    public function findById(SuscriptorNotificacionId $id): ?SuscriptorNotificacion;
}
