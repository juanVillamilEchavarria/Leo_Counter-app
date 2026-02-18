<?php

namespace App\Domains\Movimiento\Service\Domain;

use App\Domains\ArchivoMovimiento\Services\ArchivoMovimientoService;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\ArchivoMovimiento\DTOs\ThrowArchivoMovimientoDTO;
use App\Shared\Exceptions\CannotUploadFileException;
use App\Models\Movimiento\Movimiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MovimientoAttachmentService{

    public function __construct(
        private ArchivoMovimientoService $archivoMovimientoService,
        private GetCategoriaAction $getCategoriaAction
    )
    {
    }
        public function sync(UpdateMovimientoDTO | StoreMovimientoDTO $dto, Movimiento $movimiento){
            DB::transaction(function() use ($dto, $movimiento){
                $this->updateFilesWhenCategoriaChanged($dto, $movimiento);
                    $this->validateNumberOfFiles($dto);
                    $this->deleteExistingFiles($dto, $movimiento);
                    $this->storeNewFiles($dto, $movimiento);
            });
    }


    public function deleteAllAttachments(Movimiento $movimiento){
        $archivos = $movimiento->archivoMovimientos;
        foreach($archivos as $archivo){
            $this->archivoMovimientoService->delete($archivo);
        }
    }


    private function validateNumberOfFiles(UpdateMovimientoDTO | StoreMovimientoDTO $dto){
        if($dto instanceof UpdateMovimientoDTO){
            if(count($dto->newComprobantes()) + (!empty($dto->comprobantes_existing) ? count($dto->comprobantes_existing) : 0) > 3){
            throw new CannotUploadFileException("No se pueden adjuntar mas de 3 archivos por movimiento");
        }
        }
        if(count($dto->newComprobantes()) > 3){
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

    private function updateFilesWhenCategoriaChanged (UpdateMovimientoDTO $dto, Movimiento $movimiento){
        if($dto->categoria_id === $movimiento->categoria_id && $dto->tipo_movimiento_id === $movimiento->tipo_movimiento_id ) return;
        $categoria = $this->getCategoriaAction->find($dto->categoria_id);
        $tipo_movimiento = $categoria->tipoMovimiento;
        foreach($dto->comprobantes_existing as $comprobante){
             $archivos = $movimiento->archivoMovimientos()->where('id', $comprobante['id'])->get();
             foreach($archivos as $archivo){
                $dtoThrow= new ThrowArchivoMovimientoDTO(
                    comprobantes: $archivos->all(),
                    categoria: $categoria->nombre,
                    tipo_movimiento: $tipo_movimiento->tipo_movimiento,
                    movimiento_id: $movimiento->id
                );
          
                $this->archivoMovimientoService->updateLocation($dtoThrow, $archivo);
             }
            
        }
        dd('termino');
    }
    private function storeNewFiles(UpdateMovimientoDTO | StoreMovimientoDTO $dto, Movimiento $movimiento){
        if(empty($dto->newComprobantes())) return;
        $dtoArchivo = ThrowArchivoMovimientoDTO::fromMovimientoAndDTO($dto, $movimiento);
        $this->archivoMovimientoService->store($dtoArchivo);
    }
}