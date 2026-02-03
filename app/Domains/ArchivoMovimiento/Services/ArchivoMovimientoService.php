<?php

namespace App\Domains\ArchivoMovimiento\Services;

use App\Domains\ArchivoMovimiento\Actions\StoreArchivoMovimientoAction;
use App\Domains\ArchivoMovimiento\DTOs\StoreArchivoMovimientoDTO;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\Actions\UploadFileAction;
use App\Shared\DTOs\UploadFileDTO;
use App\Domains\ArchivoMovimiento\DTOs\ThrowArchivoMovimientoDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class ArchivoMovimientoService  {
    public function __construct(
        private StoreArchivoMovimientoAction $storeArchivoMovimientoAction,
        private UploadFileAction $uploadFileAction
    )
    {
    }

    public function store(ThrowArchivoMovimientoDTO $dto) : void{
        $categoria = Str::slug($dto->categoria);
        $movimiento_id = $dto->movimiento_id;
        $tipo_movimiento = $dto->tipo_movimiento;
        
        foreach($dto->comprobantes as $file){
                    $nombre_guardado = Str::uuid() . '.pdf';
                $year = Carbon::now()->year;
                $month = Carbon::now()->month;
                $path = "{$year}/{$month}/{$tipo_movimiento}/{$categoria}/";
                $dto = new StoreArchivoMovimientoDTO(
                    movimiento_id: $movimiento_id,
                    nombre_guardado: $nombre_guardado,
                    nombre_original: $file->getClientOriginalName(),
                    path: $path,
                    tamano_bytes: $file->getSize(),
                );
                $dtoUpload = new UploadFileDTO(
                    disk: $dto->disk,
                    path: $path,
                    name: $nombre_guardado,
                    file: $file
                );
                $this->uploadFileAction->upload($dtoUpload);
                $this->storeArchivoMovimientoAction->store($dto);
        }
       
    }
}