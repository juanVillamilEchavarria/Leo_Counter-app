<?php

namespace App\Domains\MovimientoPendiente\Services;

// Models
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Models\MovimientoFijo\MovimientoFijo;
//Actions
use App\Domains\MovimientoPendiente\Actions\GetMovimientoPendienteAction;
use App\Domains\MovimientoPendiente\Actions\StoreMovimientoPendienteAction;
use App\Domains\MovimientoPendiente\Actions\UpdateMovimientoPendienteAction;
use App\Domains\MovimientoPendiente\Actions\DestroyMovimientoPendienteAction;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\TipoMovimiento\Actions\GetTipoMovimientoAction;
//DTOs
use App\Domains\MovimientoPendiente\DTOs\MovimientoPendienteFormOptionsDTO;
use App\Domains\MovimientoPendiente\DTOs\UpdateMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\DTOs\StoreMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\DTOs\MarkMovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;

class MovimientoPendienteService
{
    public function __construct(
        private GetMovimientoPendienteAction $getMovimientoPendienteAction,
        private StoreMovimientoPendienteAction $storeMovimientoPendienteAction,
        private UpdateMovimientoPendienteAction $updateMovimientoPendienteAction,
        private DestroyMovimientoPendienteAction $destroyMovimientoPendienteAction,
        private GetCuentaAction $getCuentaAction,
        private GetCategoriaAction $getCategoriaAction,
        private GetTipoMovimientoAction $getTipoMovimientoAction
    )
    {
    }

    public function store (array $data): MovimientoPendiente{
        $dto = StoreMovimientoPendienteDTO::fromArray($data);
        return $this->storeMovimientoPendienteAction->store($dto);
    }

    public function update(MovimientoPendiente $movimientoPendiente, array $data): bool{
        $dto = UpdateMovimientoPendienteDTO::fromArray($data);
        return $this->updateMovimientoPendienteAction->update($movimientoPendiente, $dto);
    }

    public function destroy(MovimientoPendiente $movimientoPendiente): bool{
        return $this->destroyMovimientoPendienteAction->destroy($movimientoPendiente);
    }

    public function getAll(){
        return $this->getMovimientoPendienteAction->getAll();
    }

    public function getOptions(){
        return new MovimientoPendienteFormOptionsDTO(
            $this->getCategoriaAction->getAllWithFullDetails(),
            $this->getTipoMovimientoAction->getAll(),
            $this->getCuentaAction->allAvailable()->get(),
            MovimientoFijo::all()
        );
    }

    public function getRecordsCount(){
        return $this->getMovimientoPendienteAction->getRecordsCount();
    }

    public function markAsDone(MovimientoPendiente $movimientoPendiente, array $data): bool{
        $dto = MarkMovimientoPendienteDTO::fromArray(['estado'=> EstadosMovimientoPendiente::REALIZADO]);
        return $this->updateMovimientoPendienteAction->update($movimientoPendiente, $dto);
    }
}
