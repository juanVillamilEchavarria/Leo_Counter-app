<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Cuenta;

use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentReadRepository;
use App\Models\Cuenta\Cuenta;
use Illuminate\Database\Eloquent\Collection;

class EloquentCuentaReadRepository extends EloquentReadRepository implements CuentaReadRepositoryContract{

    protected array$relations = ['movimientos'];

    protected array $forOptionsColumns = [
        'id',
        'nombre'
    ];

    public function getForOptions(): Collection
    {
        return $this->model::query()->select($this->forOptionsColumns)->where('active', true)->get();
    }
    public function __construct()
    {
        parent::__construct(Cuenta::class);
    }

}
