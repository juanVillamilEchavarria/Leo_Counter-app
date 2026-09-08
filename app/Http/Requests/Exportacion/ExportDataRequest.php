<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Http\Requests\Exportacion;

use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * FormRequest estricto para la exportación de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
class ExportDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getTable(): ExportableTable
    {
        return ExportableTable::from($this->validated('table'));
    }

    public function getExportFormat(): ExportFormat
    {
        return ExportFormat::from($this->validated('format', ExportFormat::CSV->value));
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'table' => ['required', Rule::enum(ExportableTable::class)],
            'format' => ['nullable', 'string', Rule::enum(ExportFormat::class)],
            'filename' => ['nullable', 'string', 'max:100', 'regex:/^[a-zA-Z0-9_\-\s]+$/'],
            'only_current_page' => ['nullable', 'boolean'],
            'filters' => ['nullable', 'array'],
            'filters.search' => ['nullable', 'string'],
            'filters.sortBy' => ['nullable', 'string'],
            'filters.sortOrder' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'filters.page' => ['nullable', 'integer', 'min:1'],
            'filters.perPage' => ['nullable', 'integer', 'min:1', 'max:100'],
            'visibleIds' => ['nullable', 'array'],
            'visibleIds.*' => ['string'],
        ];
    }
}
