<?php

namespace App\Domains\Presupuesto\Actions;

use App\Models\Presupuesto\Presupuesto;
use Carbon\Carbon;
use App\Shared\Abstracts\Actions\GetAction;

class GetPresupuestoAction extends GetAction
{
    protected array $relations = ['categoria', 'user'];
    protected array $searchColumns = [
        'categoria' => [
            'categorias.nombre'
        ],
        'user' => [
            'users.name',
            'users.apellido'
        ]
    ];
    protected array $relationsColumns = [
        'categoria' => [
            'relation' => 'categoria',
            'column' => 'categorias.nombre'
        ],
        'user' => [
            'relation' => 'user',
            'column' => 'users.name'
        ]
    ];

    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }

    public function getHistoricRecordsCount(): int
    {
        return Presupuesto::whereDate('periodo', '<=', Carbon::now()->firstOfMonth())->count();
    }

    public function getMesActualRecordsCount(): int
    {
        $now = Carbon::now();
        return Presupuesto::whereDate('periodo', '=', $now->firstOfMonth())->count();
    }

    public function getEqualPresupuesto(int $categoria_id, Carbon | string $periodo): mixed
    {
        return Presupuesto::query()
            ->where('categoria_id', $categoria_id)
            ->whereDate('periodo', $periodo);
    }
}
