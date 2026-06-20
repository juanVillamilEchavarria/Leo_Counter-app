<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Http\Resources\Shared;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'currentPage' => $this->currentPage,
                'perPage' => $this->perPage,
                'lastPage' => $this->lastPage,
                'total' => $this->total,
                'from' => ($this->currentPage - 1) * $this->perPage + 1,
                'to' => min($this->total, $this->currentPage * $this->perPage),
        ];
    }
}
