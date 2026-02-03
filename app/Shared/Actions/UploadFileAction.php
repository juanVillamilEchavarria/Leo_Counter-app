<?php

namespace App\Shared\Actions;

use Illuminate\Support\Facades\Storage;
use App\Shared\DTOs\UploadFileDTO;
class UploadFileAction{
    public function upload(UploadFileDTO $dto) : bool{
        return Storage::disk($dto->disk)->putFileAs($dto->path, $dto->file, $dto->name, $dto->options) ;
    }
}