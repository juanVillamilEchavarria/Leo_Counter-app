<?php

namespace App\Infrastructure\Profile\Persistence\Repositories\Eloquent;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Profile\Contracts\Repositories\ProfileRepositoryContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

class EloquentProfileRepository extends EloquentRepository implements ProfileRepositoryContract{
    public function __construct()
    {
        return parent::__construct(User::class);
    }

}