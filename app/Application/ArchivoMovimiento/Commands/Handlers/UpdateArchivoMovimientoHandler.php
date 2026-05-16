<?php

namespace App\Application\ArchivoMovimiento\Commands\Handlers;

use App\Application\ArchivoMovimiento\Commands\UpdateArchivoMovimientoCommand;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Shared\Application\Contracts\Services\FileServiceContract;
use App\Domains\ArchivoMovimiento\Aggregates\ArchivoMovimiento;
use App\Shared\Application\DTOs\Files\MoveFileDTO;
final readonly  class UpdateArchivoMovimientoHandler
{
    public function __construct(
        private ArchivoMovimientoRepositoryContract $archivoMovimientoRepository,
        private FileServiceContract $fileService
    )
    {
    }
    public function __invoke( UpdateArchivoMovimientoCommand $command) : void
    {
        /**
         * @var ArchivoMovimiento $archivoMovimiento
         */
        $archivoMovimiento = $this->archivoMovimientoRepository->findById($command->id);
        $moveDto = new MoveFileDto(
            disk: $archivoMovimiento->getDisk(),
            oldPath: $archivoMovimiento->getPath(),
            newPath: $command->filePath,

        );
        $this->fileService->move($moveDto);
        $archivoMovimiento = $archivoMovimiento->updatePath($command->filePath);
        $this->archivoMovimientoRepository->update($archivoMovimiento);

    }

}
