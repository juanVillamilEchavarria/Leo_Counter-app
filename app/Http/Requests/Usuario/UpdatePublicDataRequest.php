<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validación para actualizar los datos públicos del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Requests\Usuario
 * @since 1.0.0
 * @version 1.0.0
 */
final class UpdatePublicDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación para nombre y correo.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        ];
    }
}
