/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useRoute } from "ziggy-js"
import { type Movimiento, type MovimientoTableData } from "../../movimiento/types/movimiento.types"
import { type MovimientoFijoFormOptions } from "../../movimientoFijo"
import type { FormCommonProps } from "@/app/shared/types/components"
import type { FileWithPreview } from "@/app/shared/types"
const route = useRoute()
export type MovimientoEspontaneo =Omit<Movimiento, 'movimiento_pendiente_id'>
export type MovimientoEspontaneoTableData = Omit<MovimientoTableData , 'fecha'| 'movimiento_pendiente_id'>

export type MovimientoEspontaneoFormData =  Omit<MovimientoEspontaneo, 'id'>  &{
    comprobantes ? : FileWithPreview[],
    comprobantes_existing ? : FileWithPreview[],
    comprobantes_delete_ids ? : number[],
    password?: string
}
export type MovimientoEspontaneoFormProps = FormCommonProps <MovimientoEspontaneoFormData> & {
    options : MovimientoFijoFormOptions
}
export const MovimientoEspontaneoRoutes = {
    index : () => route('movimientosEspontaneos.index'),
    create : () => route('movimientosEspontaneos.create'),
    edit : (id: number) => route('movimientosEspontaneos.edit', {id})

} as const

export const MovimientoEspontaneoActions ={
    post  :route('movimientosEspontaneos.store'),
    put : (id: string) => route('movimientosEspontaneos.update', {id}),
    patch : (id: string) => route('movimientosEspontaneos.update', {id}),
    delete : (id: string) => route('movimientosEspontaneos.destroy', {id})
} as const

export const MovimientoEspontaneoAPIActions={
    validateSaldo : '/validate-saldo'

}
