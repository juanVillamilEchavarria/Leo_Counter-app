<?php
namespace App\Shared\DTOs\Files;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Http\UploadedFile;
/**
 * DTO que se encarga de representar los datos necesarios para subir un archivo, este DTO es utilizado por el servicio de archivos para subir un archivo a un disco especifico, recibe el disco donde se va a subir el archivo, la ruta donde se va a subir el archivo, el nombre del archivo, el archivo en si y un array de opciones adicionales para subir el archivo
 */
class UploadFileDTO extends DTO{
    public function __construct(
        public string $disk,
        public string $path,
        public string $name,
        public UploadedFile|string $file,
        public ?array $options = []
    )
    {
    }
}