<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Framework\Laravel\ValueObjects;

use App\Shared\Application\Contracts\ValueObjects\UploadedFileContract;
use Illuminate\Http\UploadedFile as LaravelFile;

/**
 * Adaptador de la clase UploadedFile de Laravel
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelUploadedFile implements UploadedFileContract
{
    private function __construct(private LaravelFile $file)
    {
    }

    public static function fromHttp(LaravelFile $file): self
    {
        return new self($file);
    }

    public function originalName(): string
    {
        return $this->file->getClientOriginalName();
    }

    public function mimeType(): string
    {
        return $this->file->getMimeType();
    }

    public function extension(): string
    {
        return $this->file->getClientOriginalExtension();
    }

    public function size(): int
    {
        return $this->file->getSize();
    }

    public function path(): string
    {
        return $this->file->getPathname();
    }
}
