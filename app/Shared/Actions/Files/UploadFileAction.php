<?php

namespace App\Shared\Actions\Files;

use App\Shared\Application\DTOs\Files\UploadFileDTO;
use App\Shared\Exceptions\CannotUploadFileException;
use Illuminate\Support\Facades\Storage;

class UploadFileAction{
    public function upload(UploadFileDTO $dto) : bool{
        return Storage::disk($dto->disk)->putFileAs($dto->path, $dto->file, $dto->name, $dto->options) ? true : throw new CannotUploadFileException();
    }

}
