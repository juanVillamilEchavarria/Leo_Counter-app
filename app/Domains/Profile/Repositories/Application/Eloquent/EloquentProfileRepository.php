<?php

namespace App\Domains\Profile\Repositories\Application\Eloquent;
use App\Shared\Abstracts\Repositories\EloquentWriteRepository;
use App\Domains\Profile\Repositories\Contracts\ProfileRepositoryContract;
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