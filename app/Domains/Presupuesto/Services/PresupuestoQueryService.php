<?php

namespace App\Domains\Presupuesto\Services;

use App\Models\Presupuesto\Presupuesto;
use App\Shared\DTOs\Querys\TableQueryDTO;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoReadRepositoryContract;
use App\Http\Resources\Presupuesto\PresupuestoResource;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;
use App\Http\Resources\Presupuesto\PresupuestoMesActualResource;
use App\Shared\Enums\ComparativeOperators;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PresupuestoQueryService
{
    private ?\Illuminate\Pagination\LengthAwarePaginator $paginator = null;

    public function __construct(
        private PresupuestoReadRepositoryContract $presupuestoReadRepository
    )
    {
    }

    public function canDuplicate(Presupuesto $presupuesto): bool
    {
        $nextMonth = $presupuesto->periodo->copy()->firstOfMonth()->addMonth();
        return !$this->presupuestoReadRepository->getEqualPresupuesto($presupuesto->categoria_id, $nextMonth)->exists();
    }

    public function getAllWithDetails(PresupuestoVariants $type): AnonymousResourceCollection
    {
        if ($type === PresupuestoVariants::MES_ACTUAL) {
            $presupuestos = $this->presupuestoReadRepository
                ->getAllWithDetailsWhere($this->getMesActualQuery())
                ->map(function ($presupuesto) {
                    $presupuesto->isDuplicate = !$this->canDuplicate($presupuesto);
                    return $presupuesto;
                });
            return PresupuestoMesActualResource::collection($presupuestos);
        }
        
        $presupuestos = $this->presupuestoReadRepository->getAllWithDetailsWhere($this->getHistoricoQuery());
        return PresupuestoResource::collection($presupuestos);
    }

    /**
     * Get presupuestos with pagination (server-side)
     */
    public function getAllPaginated(PresupuestoVariants $variant = PresupuestoVariants::HISTORICO, TableQueryDTO $dto): AnonymousResourceCollection
    {
        $wheres = $variant === PresupuestoVariants::MES_ACTUAL ? $this->getMesActualQuery() : $this->getHistoricoQuery();
        $paginator = $this->presupuestoReadRepository->paginate($dto, $wheres);
        $this->paginator = $paginator;
      
        return PresupuestoResource::collection($paginator->items());
    }

    /**
     * Get all presupuestos with details
     */
    public function getAll(PresupuestoVariants $variant = PresupuestoVariants::HISTORICO): AnonymousResourceCollection
    {
        return $this->getAllWithDetails($variant);
    }

    /**
     * Get records count based on variant
     */
    public function getRecordsCount(PresupuestoVariants $variant = PresupuestoVariants::HISTORICO): int
    {
        return $variant === PresupuestoVariants::MES_ACTUAL
            ? $this->presupuestoReadRepository->getMesActualRecordsCount()
            : $this->presupuestoReadRepository->getHistoricRecordsCount();
    }

    /**
     * Get paginator metadata
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Get presupuesto with details
     */
    public function getWithDetails(Presupuesto $presupuesto)
    {
        return PresupuestoResource::make($this->presupuestoReadRepository->getWithDetails($presupuesto));
    }

    /**
     * Get options for forms
     */
    public function getOptions()
    {
        return $this->presupuestoReadRepository->getAllWithDetails();
    }

    /**
     * Get where conditions for mes actual variant
     */
    private function getMesActualQuery(): array
    {
        return [
            new WhereFilterQueryDTO(
                'periodo',
                ComparativeOperators::EQUALS,
                Carbon::now()->firstOfMonth()
            ),
        ];
    }

    /**
     * Get where conditions for historico variant
     */
    private function getHistoricoQuery(): array
    {
        return [
            new WhereFilterQueryDTO(
                'periodo',
                ComparativeOperators::LESS_THAN_OR_EQUAL,
                Carbon::now()->firstOfMonth()
            ),
        ];
    }
}
