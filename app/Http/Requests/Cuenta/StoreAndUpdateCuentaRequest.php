<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Requests\Cuenta;

use Illuminate\Foundation\Http\FormRequest;

class StoreAndUpdateCuentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'=>['required', 'string', 'max:25'],
            'saldo_inicial'=>['required', 'numeric', 'min:0'],
            'tipo_cuenta_id'=>['required', 'numeric'],
            'propietario_id'=>['required', 'string'],
            'notas'=>['nullable', 'string', 'max:255'],
        ];
    }
}
