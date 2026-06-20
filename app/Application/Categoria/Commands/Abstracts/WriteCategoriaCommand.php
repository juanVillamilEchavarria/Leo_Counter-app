<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Commands\Abstracts;
/**
 * Comando padre que representa la intencion de añadir una nueva categoria o actualizar una categoria existente en el sistema.
 * Este comando se utiliza para encapsular los datos necesarios para crear o actualizar una categoría, incluyendo su nombre, el tipo de movimiento asociado y una descripción opcional.
 * Esta clase existe para seguir DRY y evitar la duplicación de código entre los comandos StoreCategoriaCommand y UpdateCategoriaCommand, ya que ambos comparten los mismos atributos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class WriteCategoriaCommand
{

    public function __construct(
        public string $nombre,
        public int $tipo_movimiento_id,
        public ?string $descripcion = null
    ){}
}
