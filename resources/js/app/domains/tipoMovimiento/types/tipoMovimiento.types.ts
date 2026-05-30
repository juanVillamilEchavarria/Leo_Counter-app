/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export type TipoMovimiento ={
    id: number,
    tipo_movimiento: string
}

export const enum TiposMovimientoEnum{
    INGRESO = 1,
    GASTO = 2
}