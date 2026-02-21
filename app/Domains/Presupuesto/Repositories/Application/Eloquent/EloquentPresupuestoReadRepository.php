<?php

namespace App\Domains\Presupuesto\Repositories\Application\Eloquent;

use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoReadRepositoryContract;
use App\Shared\Abstracts\Repositories\EloquentReadRepository;
use App\Models\Presupuesto\Presupuesto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class EloquentPresupuestoReadRepository extends EloquentReadRepository implements PresupuestoReadRepositoryContract{

     protected array $relations = ['categoria', 'user'];
    protected array $searchColumns =  [
        'categoria' => [
            'categorias.nombre'
        ],
        'user' => [
            'users.name',
            'users.apellido'
        ]
    ];
    protected array $sortableRelations  = [
        'user'=>[
            'relation'=> 'user',
            'column'=> 'user.name'
        ],
        'categoria'=>[
            'relation'=> 'categoria',
            'column'=> 'categorias.nombre'
        ]
    ];
    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }

    public function getHistoricRecordsCount(): int{
        return Presupuesto::whereDate('periodo', '<=', Carbon::now()->firstOfMonth())->count();
    }

    public function getMesActualRecordsCount(): int{
        $now = Carbon::now();
        return Presupuesto::whereDate('periodo', '=', $now->firstOfMonth())->count();
    }

    public function getEqualPresupuesto(int $categoria_id, Carbon | string $periodo): Builder{
        return Presupuesto::query()
            ->where('categoria_id', $categoria_id)
            ->whereDate('periodo', $periodo);
    }

}
