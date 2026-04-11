<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Profile;
use App\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentWriteRepository;
use App\Domains\Profile\Contracts\Repositories\ProfileRepositoryContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;

class EloquentProfileRepository extends EloquentWriteRepository implements ProfileRepositoryContract{
    public function __construct()
    {
        return parent::__construct(User::class);
    }

}