<?php

namespace App\Application\ArchivoMovimiento\Commands\Handlers;

use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Domains\ArchivoMovimiento\Aggregates\ArchivoMovimiento;
use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;
use App\Shared\Application\DTOs\Files\UploadFileDTO;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Application\Contracts\Services\FileServiceContract;

/**
 * Manejador de la comando para almacenar un archivo de movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreArchivoMovimientoHandler
{

    public function __construct(
        private ArchivoMovimientoRepositoryContract $repository,
        private IdGeneratorContract $idGenerator,
        private FileServiceContract $fileService
    )
    {
    }
    public function __invoke(StoreArchivoMovimientoCommand $command): void
    {
        $archivoMovimiento = ArchivoMovimiento::create(
            id: ArchivoMovimientoId::generate($this->idGenerator),
            movimiento_id: $command->movimiento_id,
            nombre_original: $command->file->originalName(),
            disk: ArchivoMovimientoDiskEnum::DISK,
            path: $command->file_path,
            mime_type: $command->file->mimeType(),
            extension: $command->file->extension(),
            tamano_bytes: $command->file->size()
        );
        $uploadDto= new UploadFileDTO(
            disk: $archivoMovimiento->getDisk(),
            path: $archivoMovimiento->getPath(),
            name: $archivoMovimiento->getNombreGuardado(),
            file: $command->file
        );
        $this->fileService->upload($uploadDto);
        $this->repository->store($archivoMovimiento);

    }

}
