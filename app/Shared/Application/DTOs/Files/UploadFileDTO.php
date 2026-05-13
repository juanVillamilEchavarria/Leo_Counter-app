<?php
namespace App\Shared\Application\DTOs\Files;

use App\Shared\Application\Contracts\ValueObjects\UploadedFileContract;
/**
 * DTO que se encarga de representar los datos necesarios para subir un archivo, este DTO es utilizado por el servicio de archivos para subir un archivo a un disco especifico, recibe el disco donde se va a subir el archivo, la ruta donde se va a subir el archivo, el nombre del archivo, el archivo en si y un array de opciones adicionales para subir el archivo.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UploadFileDTO{
    public function __construct(
        public string $disk,
        public string $path,
        public string $name,
        public UploadedFileContract $file,
        public ?array $options = []
    )
    {
    }
}
