<?php

namespace App\Domains\Reporte\Specifications\Abstracts;

abstract class IdsSpecification{
    /**
     * @param string $param
     * el nombre de la posicion del array 
     */
    public string $param;
    public function isSatisfiedBy(array $data){
        return !empty($data[$this->param]) && is_array($data[$this->param]);
    }
}