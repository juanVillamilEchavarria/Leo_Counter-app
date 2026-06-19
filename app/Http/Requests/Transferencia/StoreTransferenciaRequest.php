<?php

namespace App\Http\Requests\Transferencia;

use Illuminate\Foundation\Http\FormRequest;

 class StoreTransferenciaRequest extends FormRequest
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
            'cuenta_origen_id'=>['required','string' ,'exists:cuentas,id'],
            'cuenta_destino_id'=>['required','string' ,'exists:cuentas,id'],
            'monto'=>['required','numeric','min:0.1'],
            'descripcion'=>['nullable','string'],
        ];
    }
}
