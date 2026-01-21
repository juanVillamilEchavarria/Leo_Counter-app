<?php

namespace App\Shared\DTOs;

abstract class DTO{
    protected array $only = [];
    protected array $except = [];
    public function toArray(){
        $array = get_object_vars($this); //devuelve un array con las propiedades del objeto y sus valores

        if (!empty($this->only)) {
            $array = array_intersect_key($array, array_flip($this->only)); // devuelve un array filtrado por solo los campos declarados en only
        }
        if (!empty($this->except)) {
            $array = array_diff_key($array, array_flip($this->except)); // devuelve un array filtrado por todos los campos menos los declarados en except
        }
        return $array;
    }
     public static function fromArray(array $data): static
    {
        return new static(...$data); // crea una nueva instancia de la clase con los valores del array
    }
}