<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Requests\Shared;

use Illuminate\Foundation\Http\FormRequest;

class TableQueryRequest extends FormRequest
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
           'page' => 'integer|min:1',
            'perPage' => 'integer|min:1|max:100',
            'search' => 'string|nullable',
            'sortBy' => 'string|nullable',
            'sortOrder' => 'in:asc,desc',
        ];
    }
}
