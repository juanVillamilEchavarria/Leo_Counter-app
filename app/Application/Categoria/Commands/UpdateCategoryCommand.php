<?php

namespace App\Application\Categoria\Commands;

use App\Application\Categoria\Commands\Abstracts\WriteCategoryCommand;

/**
 * Comando que representa la intención de actualizar una categoría existente en el sistema.
 * Este comando se utiliza para encapsular los datos necesarios para modificar una categoría, incluyendo su nombre, el tipo de movimiento asociado y una descripción opcional.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateCategoryCommand extends WriteCategoryCommand{
    public function __construct(public string $id, string $nombre, int $tipo_movimiento_id, ?string $descripcion = null)
    {
         parent::__construct($nombre, $tipo_movimiento_id, $descripcion);
    }
}