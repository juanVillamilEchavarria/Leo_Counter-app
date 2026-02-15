<?php
namespace App\Shared\Abstracts\Actions;

use App\Shared\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Abstracts\DTOs\DTO;
use App\Shared\Contracts\Actions\StoreActionContract;
abstract class StoreAction extends Action implements StoreActionContract{
    public function store(DTO $dto){
        return $this->create($dto->toArray());
    }
    protected function create(array $data){
        return ($this->model)::create($data);
    }

}