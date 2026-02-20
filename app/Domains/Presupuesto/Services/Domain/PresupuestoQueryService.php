<?php

namespace App\Domains\Presupuesto\Services\Domain;

use App\Models\Presupuesto\Presupuesto;
use App\Shared\DTOs\Querys\TableQueryDTO;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Domains\Presupuesto\Actions\GetPresupuestoAction;
use App\Domains\Presupuesto\Resources\PresupuestoResource;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;
use App\Domains\Presupuesto\Resources\PresupuestoMesActualResource;
use App\Shared\Enums\ComparativeOperators;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PresupuestoQueryService
{
    public function __construct(
        private GetPresupuestoAction $getPresupuestoAction
    )
    {
    }

    public function canDuplicate(Presupuesto $presupuesto): bool
    {
        $nextMonth = $presupuesto->periodo->copy()->firstOfMonth()->addMonth();
        return !$this->getPresupuestoAction->getEqualPresupuesto($presupuesto->categoria_id, $nextMonth)->exists();
    }

    public function getAllWithDetails(PresupuestoVariants $type): AnonymousResourceCollection
    {
        if ($type === PresupuestoVariants::MES_ACTUAL) {
            $presupuestos = $this->getPresupuestoAction
                ->getAllWithDetailsWhere($this->getMesActualQuery())
                ->map(function ($presupuesto) {
                    $presupuesto->isDuplicate = !$this->canDuplicate($presupuesto);
                    return $presupuesto;
                });
            return PresupuestoMesActualResource::collection($presupuestos);
        }
        
        $presupuestos = $this->getPresupuestoAction->getAllWithDetailsWhere($this->getHistoricoQuery());
        return PresupuestoResource::collection($presupuestos);
    }

    /**
     * Get presupuestos with pagination (server-side)
     */
    public function getAllPaginated(PresupuestoVariants $variant = PresupuestoVariants::HISTORICO, TableQueryDTO $dto): AnonymousResourceCollection
    {
        $wheres = $variant === PresupuestoVariants::MES_ACTUAL ? $this->getMesActualQuery() : $this->getHistoricoQuery();
        $data = $this->getPresupuestoAction->allPaginated($dto, $wheres);
        return PresupuestoResource::collection($data->get());
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
            ? $this->getPresupuestoAction->getMesActualRecordsCount()
            : $this->getPresupuestoAction->getHistoricRecordsCount();
    }

    /**
     * Get paginator metadata
     */
    public function getPaginator()
    {
        return $this->getPresupuestoAction->getPaginator();
    }

    /**
     * Get presupuesto with details
     */
    public function getWithDetails(Presupuesto $presupuesto)
    {
        return PresupuestoResource::make($this->getPresupuestoAction->getWithDetails($presupuesto));
    }

    /**
     * Get options for forms
     */
    public function getOptions()
    {
        return $this->getPresupuestoAction->getAllWithDetails();
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
