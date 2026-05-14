<?php

namespace App\Http\Requests\Shared;

use Illuminate\Foundation\Http\FormRequest;

class SaldoValidateRequest extends FormRequest
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
            'cuenta_id'=>['required', 'string', 'exists:cuentas,id'],
            'monto'=>['required', 'numeric', 'min:0'],
            'movimiento_id'=>['nullable', 'string', 'exists:movimientos,id']
        ];
    }
}
