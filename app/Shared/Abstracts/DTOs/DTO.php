<?php

namespace App\Shared\Abstracts\DTOs;
use App\Shared\Contracts\DTOs\DTOContract;
/**
 * Data transfer object abstracto que implementa la interfaz DTOContract, proporcionando una implementación base para la conversión de objetos a arrays y la creación de objetos a partir de arrays u otros objetos. Incluye funcionalidades para filtrar campos específicos al convertir a array y para mapear campos de otros objetos a los campos del DTO.
 * @method static fromArray(array $data): static Crea una instancia del DTO a partir de un array de datos.
 * @method array toArray(): array Convierte la instancia del DTO a un array, aplicando los filtros de campos definidos en las propiedades $only y $except.
 * @method static fromObject(object $object): static Crea una instancia del DTO a partir de otro objeto, mapeando los campos del objeto a los campos del DTO según la configuración definida en la propiedad estática $convert.
 * @method self setExcept(array $except): self Permite agregar campos a la lista de campos a excluir al convertir el DTO a un array, devolviendo la instancia del DTO para permitir la encadenación de métodos.
 */
abstract class DTO implements DTOContract {
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