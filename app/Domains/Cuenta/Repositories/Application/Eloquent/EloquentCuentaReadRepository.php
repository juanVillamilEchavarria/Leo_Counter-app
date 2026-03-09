<?php

namespace App\Domains\Cuenta\Repositories\Application\Eloquent;

use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Shared\Abstracts\Repositories\EloquentReadRepository;
use App\Models\Cuenta\Cuenta;
use Illuminate\Database\Eloquent\Collection;

class EloquentCuentaReadRepository extends EloquentReadRepository implements CuentaReadRepositoryContract{

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
