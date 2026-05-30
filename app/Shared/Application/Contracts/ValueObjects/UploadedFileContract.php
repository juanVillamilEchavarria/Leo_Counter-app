<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\ValueObjects;


/**
 * Contrato de un value object que define las propiedades de un archivo subido.
 * Esta interfaz garantiza el desacoplamiento total para que el valor del archivo subido
 * pueda ser manejado de manera transparente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface UploadedFileContract
{
    /**
     * Retorna el nombre original del archivo subido
     * @return string
     */
    public function originalName(): string;

    /**
     * Retorna el tipo mime del archivo subido
     * @return string
     */
    public function mimeType(): string;

    /**
     * Retorna la extension del archivo subido
     * @return string
     */
    public function extension(): string;

    /**
     * Retorna el tamaño del archivo subido
     * @return int
     */
    public function size(): int;

    /**
     * Retorna el path del archivo subido
     * @return string
     */
    public function path(): string;

}
