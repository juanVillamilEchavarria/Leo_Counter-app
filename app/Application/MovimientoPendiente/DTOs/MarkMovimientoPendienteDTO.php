<?php

// ┌──────────────────────────────────────────────────────────────────────────┐
// │ ARCHIVO OBSOLETO — Comentado completamente tras el refactor CQRS/DDD   │
// │ del módulo MovimientoPendiente.                                         │
// │                                                                         │
// │ Este DTO fue usado por la funcionalidad de marcar como realizado        │
// │ del servicio legacy. Se mantiene para referencia hasta que el           │
// │ Arquitecto implemente esa funcionalidad en el nuevo patrón.            │
// │                                                                         │
// │ NO ELIMINAR hasta que se confirme la estabilidad del refactor.          │
// └──────────────────────────────────────────────────────────────────────────┘

// namespace App\Application\MovimientoPendiente\DTOs;
//
// use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
// use App\Shared\Abstracts\DTOs\DTO;
// class MarkMovimientoPendienteDTO extends DTO
// {
//     public function __construct(
//         public ?EstadosMovimientoPendiente $estado
//     ){}
// }