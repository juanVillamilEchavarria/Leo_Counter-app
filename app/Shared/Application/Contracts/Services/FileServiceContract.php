<?php

namespace App\Shared\Application\Contracts\Services;
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
     * @param string $disk
     * @return bool
     */
    public function destroy(string $path, string $disk): bool;

    /**
     * Verifica si un archivo de movimientos existe.
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function exists(string $path, string $disk): bool;

}
