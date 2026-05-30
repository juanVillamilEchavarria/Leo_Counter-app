/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */

import { route } from "ziggy-js"
import { type Comprobante } from "../../archivoMovimiento"
import type { MovimientoEspontaneoFormData } from "../../movimientoEspontaneo"

export const MovimientoRoutes={
    index : ()=>route('movimientos.index'),
    show : (id: number) => route('movimientos.show', {id}),
}
export const MovimientoApiActions={
    paginatedData: '/movimientos'
}
export type Movimiento={
    id: string,
    nombre: string,
    categoria_id?: string,
    cuenta_id: string,
    tipo_movimiento_id: number,
    monto: number,
    fecha: string,
    descripcion: string,
    movimiento_pendiente_id: string | null,
}

export type MovimientoTableData= Omit<Movimiento, 'movimiento_pendiente_id'| 'categoria_id' | 'cuenta_id' | 'tipo_movimiento_id'> & {
        categoria: string,
        cuenta: string,
        tipo_movimiento: string
    }
    export type MovimientoData =  Omit<Movimiento, 'movimiento_pendiente_id'| 'categoria_id' | 'cuenta_id' | 'tipo_movimiento_id'> & {
        categoria: string,
        cuenta: string,
        tipo_movimiento: string
        comprobantes : Comprobante[]
    }

    export type MovimientoShowData= MovimientoTableData &{
        comprobantes ?: Comprobante[]

    }
