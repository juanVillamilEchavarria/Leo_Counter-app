<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Services;

/**
 * Servicio que compacta un string HTML eliminando los espacios en blanco.
 *
 * @package App\Shared\Application\Services
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CompactHTMLBodyService{
    public function compact(string $html): string
    {
        $search = [
            '/\s+/u',
            '//ms',
        ];
        $replace = [' ', ''];
        return preg_replace($search, $replace, $html);
    }
}
