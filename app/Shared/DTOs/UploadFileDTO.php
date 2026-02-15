<?php
namespace App\Shared\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Http\UploadedFile;
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