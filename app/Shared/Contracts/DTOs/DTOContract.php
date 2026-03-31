<?php
namespace App\Shared\Contracts\DTOs;
/**
 * Contrato que deben implementar todos los DTOs de la aplicacion, este contrato define los metodos que deben implementar todos los DTOs, como el metodo fromArray y toArray, que se encargan de convertir un array en un DTO y un DTO en un array respectivamente
 * @method static fromArray(array $data): static
 * @method toArray(): array
 */
interface DTOContract{
    public static function fromArray(array $data): self;
    public function toArray(): array;
}