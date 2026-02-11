export type TipoMovimiento ={
    id: number,
    tipo_movimiento: string
}

export const enum TiposMovimientoEnum{
    INGRESO = 1,
    GASTO = 2
}