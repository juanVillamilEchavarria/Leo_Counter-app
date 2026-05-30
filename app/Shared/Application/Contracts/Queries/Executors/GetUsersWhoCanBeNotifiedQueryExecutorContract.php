<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Domains\Usuario\Aggregates\Usuario;

/**
 * Ejecutor de la consulta de obtencion de todos los usuarios que estan habilitados para ser notificados al menos por un canal
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetUsersWhoCanBeNotifiedQueryExecutorContract
{
    /**
     * obtiene los usuarios que pueden ser notificados
     * @return CollectionContract<Usuario>
     */
    public function execute(): CollectionContract;

}
