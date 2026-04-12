<?php
namespace App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent;

use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentReadRepository;
use App\Models\Movimiento\Movimiento;
use Illuminate\Support\Carbon;

class EloquentMovimientoReadRepository extends EloquentReadRepository implements MovimientoReadRepositoryContract{

     protected array $relations = ['cuenta', 'categoria', 'movimientoPendiente', 'tipo_movimiento'];
    protected array $searchColumns = [
        'nombre'=> 'nombre',
        'descripcion'=> 'descripcion',
        'monto'=> 'monto',
        'fecha'=> 'fecha',
        'cuenta'=>[
            'cuentas.nombre'
        ],
        'categoria'=>[
            'categorias.nombre'
        ]
    ];
    protected array $sortableRelations  = [
        'cuenta'=>[
           'relation'=> 'cuenta',
           'column'=> 'cuentas.nombre'
        ],
        'tipo_movimiento'=>[
            'relation'=> 'tipo_movimiento',
            'column'=> 'tipo_movimientos.tipo_movimiento'
        ],
        'categoria'=>[
            'relation'=> 'categoria',
            'column'=> 'categorias.nombre'
        ]
    ];
    public function __construct()
    {
        parent::__construct(Movimiento::class);
    }
    public function getEspontaneoRecordsCount(): int{
        return Movimiento::where('movimiento_pendiente_id', null)->where('fecha', Carbon::now()->format('Y-m-d'))->count();
    }
} /** @var class-string<Model> $model */