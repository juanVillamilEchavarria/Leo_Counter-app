<?php

namespace App\Shared\Infrastructure\Framework\Laravel\Builders;
use App\Shared\Infrastructure\Framework\Laravel\ValueObjects\LaravelUploadedFile;

/**
 * Builder para LaravelUploadedFile
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelUploadedFileBuilder
{

    /**
     * Devuelve un array de LaravelUploadedFile
     * @param array $comprobantes
     * @return array<LaravelUploadedFile>
     */
    public static function many(?array $comprobantes): array{
        $cmp = [];
        if($comprobantes === null){
            return $cmp;
        }
        foreach($comprobantes as $comprobante){
            $cmp[]= LaravelUploadedFile::fromHttp($comprobante);
        }
        return $cmp;
    }

}
