import { TiposMovimientoEnum } from "../types/tipoMovimiento.types"
export const isGasto = (tipoMovimiento?: number)=>{
    return tipoMovimiento === TiposMovimientoEnum.GASTO
}

export const isIngreso = (tipoMovimiento?: number)=>{
    return tipoMovimiento === TiposMovimientoEnum.INGRESO
}