<?php

namespace App\Shared\Actions;

use Illuminate\Support\Facades\Storage;
use App\Shared\DTOs\UploadFileDTO;

use App\Shared\Exceptions\CannotUploadFileException;
class UploadFileAction{
    public function upload(UploadFileDTO $dto) : bool{
        return Storage::disk($dto->disk)->putFileAs($dto->path, $dto->file, $dto->name, $dto->options) ? true : throw new CannotUploadFileException();
    }
}