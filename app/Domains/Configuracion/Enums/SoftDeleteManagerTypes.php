<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Configuracion\Enums;


enum SoftDeleteManagerTypes : string{

    protected const BaseViewURL= 'Configuracion/Deleted/';
    case CUENTAS = 'cuentas';
    case CATEGORIAS = 'categorias';
    case MOVIMIENTOS_PENDIENTES = 'movimientosPendientes';
    case PRESUPUESTOS = 'presupuestos';

    public function view(){
        return match($this){
            self::CUENTAS =>  $this::BaseViewURL.'Cuentas',
            self::CATEGORIAS => $this::BaseViewURL. 'Categorias',
            self::MOVIMIENTOS_PENDIENTES => $this::BaseViewURL. 'Movimientos Pendientes',
            self::PRESUPUESTOS => $this::BaseViewURL. 'Presupuestos',
        };
    }

    public function label(){
        return match($this){
            self::CUENTAS =>  'Cuentas',
            self::CATEGORIAS => 'Categorias',
            self::MOVIMIENTOS_PENDIENTES => 'Movimientos Pendientes',
            self::PRESUPUESTOS => 'Presupuestos',
        };
    }

    public static function try(string $type): ?self{
        return self::tryFrom($type) ?? throw new \LogicException('No se encontro un manager para el dominio especificado');

    }
}
