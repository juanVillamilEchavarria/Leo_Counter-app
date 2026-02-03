<?php

namespace App\Domains\ArchivoMovimiento\Services;

use App\Domains\ArchivoMovimiento\Actions\StoreArchivoMovimientoAction;
use App\Domains\ArchivoMovimiento\DTOs\StoreArchivoMovimientoDTO;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\Actions\UploadFileAction;
use App\Shared\DTOs\UploadFileDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class ArchivoMovimientoService  {
    public function __construct(
        private StoreArchivoMovimientoAction $storeArchivoMovimientoAction,
        private UploadFileAction $uploadFileAction
    )
    {
    }

    public function store(array $data){
        $categoria = Str::slug($data['categoria']);
        $movimiento_id = 1;
        $tipo_movimiento = $data['tipo_movimiento'];
        
        foreach($data as $key => $value){
            if(is_array($value)){
                foreach($value as $file){
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
                 return $this->storeArchivoMovimientoAction->store($dto);
                }
                
            }
        }
       
    }
}