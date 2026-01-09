<?php

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
            'saldo_inicial'=>['required', 'numeric'],
            'tipo_cuenta_id'=>['required', 'numeric'],
            'propietario_id'=>['required', 'numeric'],
            'notas'=>['nullable', 'string', 'max:255'],
        ];
    }
}
