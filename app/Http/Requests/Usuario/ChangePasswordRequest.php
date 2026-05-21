<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validación para cambiar la contraseña del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Requests\Usuario
 * @since 1.0.0
 * @version 1.0.0
 */
final class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación para el cambio de contraseña.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ];
    }
}
