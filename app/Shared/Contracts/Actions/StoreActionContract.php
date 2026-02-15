<?php

namespace App\Shared\Contracts\Actions;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;

interface StoreActionContract{
    public function store(DTO $data);
}