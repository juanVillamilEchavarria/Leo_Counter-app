<?php
namespace App\Http\Resources\Configuracion\Abstracts;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;

/**
 * Clase padre para los recursos de registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Http\Resources\Configuracion\Abstracts
 * @since 1.0.0
 * @version 1.0.0
 */
abstract class SoftDeleteResource extends JsonResource
{
    /**
     * Estrategia de manejo de registros eliminados
     */
    protected SoftDeleteManagerContract $manager;
    /**
     * Establece la estrategia de manejo de registros eliminados
     */
    public function setManager (SoftDeleteManagerContract $manager): self{
        $this->manager = $manager;
        return $this;
    }
}
