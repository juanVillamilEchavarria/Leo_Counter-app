<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Services;
use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Shared\Application\DTOs\Files\MoveFileDTO;
use App\Shared\Application\DTOs\Files\UploadFileDTO;

/**
 * Contrato que define los metodos para subir y mover archivos en el storage.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface FileServiceContract
{
    /**
     * Sube un archivo
     * @param UploadFileDTO $dto
     * @return bool
     */
    public function upload(UploadFileDTO $dto) : bool;

    /**
     * Mueve un archivo
     * @param MoveFileDTO $dto
     * @return bool
     */
    public function move(MoveFileDTO $dto): bool;


    /**
     * Elimina un archivo
     * @param string $path
     * @param ArchivoMovimientoDiskEnum $disk
     * @return bool
     */
    public function destroy(string $path, ArchivoMovimientoDiskEnum $disk): bool;

    /**
     * Verifica si un archivo de movimientos existe.
     * @param string $path
     * @param ArchivoMovimientoDiskEnum $disk
     * @return bool
     */
    public function exists(string $path, ArchivoMovimientoDiskEnum $disk): bool;

}
