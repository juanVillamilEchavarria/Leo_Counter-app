<?php

namespace App\Http\Requests\Presupuesto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
class StoreAndUpdatePresupuestoMesActualRequest extends FormRequest
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
            'categoria_id' => [
                    'required',
                    'string',
                    'exists:categorias,id',
                    Rule::unique('presupuestos')
                        ->where(fn ($q) =>
                            $q->where('periodo', Carbon::now()->firstOfMonth())
                            ->where('categoria_id', $this->categoria_id)
                        )
                        ->ignore($this->id),
                ],
            'monto' => ['required','numeric','min:0'],
            'descripcion' => ['nullable','string','max:80'],
        ];
    }
}
