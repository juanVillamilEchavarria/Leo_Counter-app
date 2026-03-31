<?php
namespace App\Shared\ValueObjects;

use Illuminate\Support\Facades\Hash;
/**
 * Value Object de password, se encarga de validar la contraseña y hashearla antes de ser almacenada en la base de datos.
 */
final class Password{
    public const MIN_LENGTH = 8;
    public function __construct(private string $password)
    {
        if(strlen($password) < self::MIN_LENGTH){
            throw new \InvalidArgumentException('La contraseña debe tener al menos 8 caracteres');
        }
        $this->password = Hash::make($password);
    }
    public function __toString(): string
    {
        return $this->password;
    }
}