/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { TiposMovimientoEnum } from "../types/tipoMovimiento.types"
export const isGasto = (tipoMovimiento?: number)=>{
    return tipoMovimiento === TiposMovimientoEnum.GASTO
}

export const isIngreso = (tipoMovimiento?: number)=>{
    return tipoMovimiento === TiposMovimientoEnum.INGRESO
}