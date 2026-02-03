<?php

namespace App\Shared\DTOs;

abstract class DTO{
    protected array $only = []; // solo se devolveran estos campos
    protected array $except = []; // no se devolveran estos campos
    protected static array $convert = []; // se convertiran estos campos en el fromObject
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
        public static function fromObject(object $object): static {
            $props = (new \ReflectionClass(static::class))->getProperties(\ReflectionProperty::IS_PUBLIC); // obtiene los parametros publicos del DTO

            $allowed = array_map(fn($prop) => $prop->getName(), $props); // obtiene los nombres de los parametros

            $attributes = method_exists($object, 'getAttributes') ? $object->getAttributes() : get_object_vars($object); // obtiene los atributos del objeto

            $data = [];
            foreach($allowed as $prop){ //recorre cada propiedad/parametro del DTO
                
                if(property_exists(static::class, 'convert') && array_key_exists($prop, static::$convert)){ // verifica si existe el array de convert y si la propiedad esta en el array
                    
                    $convertKeys = static::$convert[$prop]; // obtiene las llaves de conversion de la propiedad
                    
                    foreach($convertKeys as $convertKey){ // recorre las llaves de conversion
                        
                        $data[$prop]= $attributes[$convertKey]; // asigna el valor de la propiedad a la llave de conversion
                        
                        break; // asigna el primer valor y sale del bucle
                        
                    }
                }else if(array_key_exists($prop, $attributes) ){ // sino hay un array de conversion, se asigna el valor de la propiedad
                    $data[$prop] = $attributes[$prop];
                }
            }
            return new static(...array_values($data));
        }
}