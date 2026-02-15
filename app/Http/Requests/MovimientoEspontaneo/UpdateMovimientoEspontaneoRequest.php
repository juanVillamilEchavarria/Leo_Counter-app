<?php

namespace App\Http\Requests\MovimientoEspontaneo;

use App\Http\Requests\MovimientoEspontaneo\StoreMovimientoEspontaneoRequest;

class UpdateMovimientoEspontaneoRequest extends StoreMovimientoEspontaneoRequest
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
        return array_merge(parent::rules(),[
            'comprobantes_delete_ids'=> ['nullable', 'array'],
            'comprobantes_existing'=> ['nullable', 'array'],
        ]);
    }
}
