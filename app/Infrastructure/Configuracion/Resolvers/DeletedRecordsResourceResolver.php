<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Configuracion\Resolvers;

use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Infrastructure\Configuracion\Contracts\DeletedRecordsResourceStrategyContract;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resolver que elige la estrategia de Resource adecuada para un tipo de SoftDeleteManager.
 */
final readonly class DeletedRecordsResourceResolver
{
    /**
     * @param iterable<DeletedRecordsResourceStrategyContract> $strategies
     */
    public function __construct(private iterable $strategies)
    {
    }

    public function resolve(SoftDeleteManagerTypes $type, CollectionContract $data): JsonResource
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type)) {
                return $strategy->makeResource($data);
            }
        }

        throw new \LogicException('No se pudo resolver la estrategia de recursos para los registros eliminados');
    }
}
