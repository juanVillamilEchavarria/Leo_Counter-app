<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Collections\FormOptions;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que representa la coleccion de categorias para el formulario de reporte financiero.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Collections\FormOptions
 * @since 1.0.0
 *  @version 1.0.0
 */
interface CategoriaForFormCollectionContract extends CollectionContract {
    /**
     * Devuelve las categorias de ingresos.
     * @return CollectionContract
     */
    public function ingresos(): CollectionContract;
    /**
     * Devuelve las categorias de gastos.
     * @return CollectionContract
     */
    public function gastos(): CollectionContract;
}