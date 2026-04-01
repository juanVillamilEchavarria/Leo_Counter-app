<?php

namespace App\Shared\Contracts\Repositories;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
/**
 * Contrato que implementaran los repositorios de lectura que su modelo tiene soft deletes, para obtener los registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface SoftDeleteReadRepositoryContract {
    /**
     * Obtiene todos los registros eliminados
     * @return Collection<Model>
     */
    public function getAllDeleted() : Collection;
}