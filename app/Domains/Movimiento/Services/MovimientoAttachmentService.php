<?php

namespace App\Domains\Movimiento\Services;

use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\DTOs\ArchivoMovimientoTransferDTO;
use App\Application\ArchivoMovimiento\Services\ArchivoMovimientoService;
use App\Application\Movimiento\DTOs\StoreMovimientoDTO;
use App\Application\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use App\Domains\Movimiento\Specifications\MovimientoLocationChanged;
use App\Models\Categoria\Categoria;
use App\Models\Movimiento\Movimiento;
use App\Shared\Exceptions\CannotUploadFileException;
use Illuminate\Support\Facades\DB;

class MovimientoAttachmentService{

    private const MAX_FILES = 3;
    public function __construct(
        private ArchivoMovimientoService $archivoMovimientoService,
        private FilePathBuilder $filePathBuilder,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private MovimientoLocationChanged $movimientoLocationChanged
    )
    {
    }
        public function sync(UpdateMovimientoDTO | StoreMovimientoDTO $dto, Movimiento $movimiento){
            DB::transaction(function() use ($dto, $movimiento){
                $categoria = $this->getCategoria($dto);
                $dto instanceof UpdateMovimientoDTO && $this->updateFiles($dto, $movimiento, $categoria);
                    $this->validateNumberOfFiles($dto);
                    $this->deleteExistingFiles($dto, $movimiento);
                    $this->storeNewFiles($dto, $movimiento, $categoria);
            });
    }


    private function getCategoria ( UpdateMovimientoDTO | StoreMovimientoDTO $dto){
        return $this->categoriaReadRepository->find($dto->categoria_id);
    }
    public function deleteAllAttachments(Movimiento $movimiento){
        $archivos = $movimiento->archivoMovimientos;
        foreach($archivos as $archivo){
            $this->archivoMovimientoService->delete($archivo);
        }
    }


    private function validateNumberOfFiles(UpdateMovimientoDTO | StoreMovimientoDTO $dto){
        $newFilesCount = count($dto->newComprobantes());
        $existingFilesCount = $dto instanceof UpdateMovimientoDTO && !empty($dto->comprobantes_existing) ? count($dto->comprobantes_existing) : 0;
        $totalFiles = $newFilesCount + $existingFilesCount;
        if($totalFiles > self::MAX_FILES){
                throw new CannotUploadFileException("No se pueden adjuntar mas de 3 archivos por movimiento");
        }
    }

    private function deleteExistingFiles(UpdateMovimientoDTO | StoreMovimientoDTO $dto, Movimiento $movimiento){
        if(!$dto instanceof UpdateMovimientoDTO || $dto->comprobantes_delete_ids === null) return;
        $archivos =$movimiento->archivoMovimientos()->whereIn('id', $dto->comprobantes_delete_ids)->get();
        if(empty($archivos)) return;
         foreach($archivos as $archivo){
          $this->archivoMovimientoService->delete($archivo);
         }
    }

    private function updateFiles (UpdateMovimientoDTO $dto, Movimiento $movimiento, Categoria $categoria){
        if(!$this->movimientoLocationChanged->isSatisfiedBy($movimiento, $dto)) return;
        if(empty($dto->comprobantes_existing)) return; // si no hay archivos existentes, no hay que mover nada
        $ids = collect($dto->comprobantes_existing)->pluck('id')->all();
        $filesToMove = $movimiento->archivoMovimientos()
                        ->whereIn('id', $ids)
                        ->when($dto->comprobantes_existing, function($query) use ($dto){
                            $query->whereNotIn('id', $dto->comprobantes_delete_ids ?? []);
                        })->get();

        $filePath = $this->filePathBuilder->buildFromData($categoria->tipoMovimiento->tipo_movimiento, $categoria->nombre);
        $filesToMove->isNotEmpty() && $this->archivoMovimientoService->moveFiles($filesToMove, $filePath);
    }
    private function storeNewFiles(UpdateMovimientoDTO | StoreMovimientoDTO $dto, Movimiento $movimiento, Categoria $categoria){
        if(empty($dto->newComprobantes())) return;
        $dtoArchivo = ArchivoMovimientoTransferDTO::fromMovimientoAndDTO($dto, $movimiento);
        $filePath = $this->filePathBuilder->buildFromData($categoria->tipoMovimiento->tipo_movimiento, $categoria->nombre);
        $this->archivoMovimientoService->store($dtoArchivo, $filePath);
    }
}
