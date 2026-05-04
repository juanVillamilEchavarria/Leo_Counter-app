<?php

namespace App\Shared\Application\Contracts\Queries\Executors\FormOptions\Abstracts;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que debe implementar cada dominio que sea una opción para los formularios, para ser listada en el formulario de creación y edicion.
 *Debe traer unicamente los campos necesarios, entre mas sencillos sea el query, mejor.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListForFormContract{
    /**
     * Ejecuta el query para obtener las opciones de formulario
     * @return CollectionContract Una colección de la opcion del formulario
     */
    public function execute(): CollectionContract;
}