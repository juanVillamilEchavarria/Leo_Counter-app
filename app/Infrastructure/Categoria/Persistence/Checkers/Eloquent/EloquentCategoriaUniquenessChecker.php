<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Categoria\Persistence\Checkers\Eloquent;

use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Models\Categoria\Categoria as CategoriaModel;

final readonly class EloquentCategoriaUniquenessChecker implements CategoriaUniquenessCheckerContract
{
    public function exists(string $nombre, int $tipoMovimientoId, ?string $excludeId = null): bool
    {
        $query = CategoriaModel::where('nombre', $nombre)
            ->where('tipo_movimiento_id', $tipoMovimientoId);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}