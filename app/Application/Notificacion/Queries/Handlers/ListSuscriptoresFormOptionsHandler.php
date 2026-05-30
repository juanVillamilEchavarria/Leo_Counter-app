<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Queries\Handlers;
use App\Application\Notificacion\Queries\Handlers\FormOptions\ListCanalNotificacionForFormContract;
use App\Application\Notificacion\Queries\ListSuscriptoresFormOptionsQuery;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListUsuarioForFormContract;
use App\Application\Notificacion\DTOs\SuscriptoresFormOptionsDTO;
use App\Shared\Domain\Contracts\CollectionContract;

final readonly class ListSuscriptoresFormOptionsHandler
{
    public function __construct(
        private ListUsuarioForFormContract $listUsuarioForForm,
        private ListCanalNotificacionForFormContract $listCanalesForFormContract
    )
    {
    }
    public function __invoke( ListSuscriptoresFormOptionsQuery $query) : SuscriptoresFormOptionsDTO
    {
        $usuarios = $this->listUsuarioForForm->execute();
        $canales = $this->listCanalesForFormContract->execute();
        return new SuscriptoresFormOptionsDTO(
            usuarios : $usuarios,
            canales: $canales
        );
    }

}
