<?php

namespace App\Domains\ArchivoMovimiento\ValueObjects;

use Stringable;

class FilePath implements Stringable{
    public function __construct(
        public readonly int $year,
        public readonly int $month,
        public readonly string $tipo_movimiento,
        public readonly string $categoria,
    )
    {
    }

    public static function create(int $year, int $month, string $tipo_movimiento, string $categoria): self{
        return new self($year, $month, $tipo_movimiento, $categoria);
    }

    public static function fromString(string $path): self{
        $parts = explode('/', trim($path, '/'));
        if(count($parts) !== 4){
            throw new \InvalidArgumentException('Invalid path format');
        }
        return new self(
            year: (int)$parts[0],
            month: (int)$parts[1],
            tipo_movimiento: $parts[2],
            categoria: $parts[3]
         );
    }

    public function toString():string{

        return sprintf(
            '%d/%d/%s/%s/',
            $this->year,
            $this->month,
            $this->tipo_movimiento,
            $this->categoria
        );

    }
    public function __toString(): string
    {
        return $this->toString();
    }

    public function withCategoriaAndTipoMovimiento(string $categoria, string $tipo_movimiento): self{
        return new self(
            year: $this->year,
            month: $this->month,
            tipo_movimiento: $tipo_movimiento,
            categoria: $categoria
        );
    }

    public function equals(FilePath $other): bool{
        return $this->toString() === $other->toString();
    }

}
