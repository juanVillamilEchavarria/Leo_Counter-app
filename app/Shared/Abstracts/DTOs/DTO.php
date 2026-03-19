<?php

namespace App\Shared\Abstracts\DTOs;

abstract class DTO{
    /**
     * Propiedad para declarar los campos unicos que se devolveran
     * Formato : ['campo1', 'campo2',...]
     * @var array<string>
     */
    protected array $only = [];
    /**
     * Propiedad para declarar los campos que no se devolveran
     * Formato : ['campo1', 'campo2',... ]
     * @var array<string>
     */ 
    protected array $except = []; 
    /**
     * Propiedad para convertir los campos de otro objeto con otro nombre a los campos de este DTO
     * Formato : ['campo_DTO' => ['campo_objeto', 'campo_objeto',...]]
     * @var array
     */
    protected static array $convert = [];
    public function toArray(): array{
        $array = get_object_vars($this); 
        /**
         * Se filtra el array dependiendo si hay campos declarados en only o except
         */
        if (!empty($this->only)) {
            $array = array_intersect_key($array, array_flip($this->only)); 
        }
        if (!empty($this->except)) {
            $array = array_diff_key($array, array_flip($this->except)); 
        }
        return $array;
    }
     public static function fromArray(array $data): static
    {

        return new static(...$data); 
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
   
        public function setExcept (array $except){
            $this->except =[
                ...$this->except,
                ...$except
            ];
            return $this;
        }
}