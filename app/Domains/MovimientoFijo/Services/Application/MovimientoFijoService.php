<?php 

namespace App\Domains\MovimientoFijo\Services\Application;

// Models
use App\Models\MovimientoFijo\MovimientoFijo;
// Domain Services
use App\Domains\MovimientoFijo\Services\Domain\MovimientoFijoQueryService;
// Contracts
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoWriteRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Repositories\Contracts\FrecuenciaMovimientoReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
// DTOs
use App\Domains\MovimientoFijo\DTOs\MovimientoFijoFormOptionsDTO;
use App\Domains\MovimientoFijo\DTOs\UpdateMovimientoFijoDTO;
use App\Domains\MovimientoFijo\DTOs\StoreMovimientoFijoDTO;
// Resources
use App\Domains\MovimientoFijo\Resources\MovimientoFijoResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * MovimientoFijoService
 * 
 * Servicio de aplicación encargado de coordinar operaciones relacionadas con MovimientoFijo.
 * Delega responsabilidades de lectura al MovimientoFijoQueryService y de escritura al Repository.
 * 
 * Este servicio actúa como orquestador entre la capa de Controllers y los servicios de dominio,
 * proporcionando una interfaz limpia para las operaciones más complejas.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Services\Application
 * @since 1.0.0
 */
class MovimientoFijoService
{
    public function __construct(
        private MovimientoFijoQueryService $movimientoFijoQueryService,
        private MovimientoFijoWriteRepositoryContract $movimientoFijoWriteRepository,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository,
        private FrecuenciaMovimientoReadRepositoryContract $frecuenciaMovimientoReadRepository,
        private CuentaReadRepositoryContract $cuentaReadRepository
    )
    {
    }

    /**
     * Crea un nuevo movimiento fijo
     * 
     * @param array $data
     * @return MovimientoFijo
     */
    public function store(array $data): MovimientoFijo
    {
        $dto = StoreMovimientoFijoDTO::fromArray($data);
        return $this->movimientoFijoWriteRepository->store($dto);
    }

    /**
     * Actualiza un movimiento fijo existente
     * 
     * @param MovimientoFijo $movimientoFijo
     * @param array $data
     * @return bool
     */
    public function update(MovimientoFijo $movimientoFijo, array $data): bool
    {
        $dto = UpdateMovimientoFijoDTO::fromArray($data);
        return $this->movimientoFijoWriteRepository->update($movimientoFijo, $dto);
    }

    /**
     * Elimina un movimiento fijo
     * 
     * @param MovimientoFijo $movimientoFijo
     * @return bool
     */
    public function destroy(MovimientoFijo $movimientoFijo): bool
    {
        return $this->movimientoFijoWriteRepository->destroy($movimientoFijo);
    }

    /**
     * Alterna el valor de un atributo booleano del movimiento fijo
     * 
     * @param MovimientoFijo $movimientoFijo
     * @param string $attribute
     * @return bool
     */
    public function toggle(MovimientoFijo $movimientoFijo, string $attribute): bool
    {
        return $this->movimientoFijoWriteRepository->toggle($movimientoFijo, $attribute);
    }

    /**
     * Obtiene todos los movimientos fijos con sus relaciones
     * Delega al QueryService
     * 
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        $movimientos = $this->movimientoFijoQueryService->getAllWithDetails();
        return MovimientoFijoResource::collection($movimientos);
    }

    /**
     * Obtiene las opciones para los formularios (selects)
     * 
     * @return MovimientoFijoFormOptionsDTO
     */
    public function getOptions(): MovimientoFijoFormOptionsDTO
    {
        return new MovimientoFijoFormOptionsDTO(
            $this->categoriaReadRepository->getAllWithFullDetails(),
            $this->tipoMovimientoReadRepository->getAll(),
            $this->frecuenciaMovimientoReadRepository->getAll(),
            $this->cuentaReadRepository->whereAttr('active', true)->get()
        );
    }

    /**
     * Obtiene el conteo total de registros
     * Delega al QueryService
     * 
     * @return int
     */
    public function getRecordsCount(): int
    {
        return $this->movimientoFijoQueryService->getRecordsCount();
    }
}
