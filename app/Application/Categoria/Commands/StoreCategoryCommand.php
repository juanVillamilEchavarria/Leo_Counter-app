<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Commands;
use App\Application\Categoria\Commands\Abstracts\WriteCategoryCommand;
/**
 * Comando que representa la intención de almacenar una nueva categoría en el sistema.
 * Este comando se utiliza para encapsular los datos necesarios para crear una nueva categoría, incluyendo su nombre, el tipo de movimiento asociado y una descripción opcional.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreCategoryCommand extends WriteCategoryCommand
{
}