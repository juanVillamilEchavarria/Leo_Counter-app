import { type FormCommonProps } from "@/app/shared/types/components"
import { type TipoMovimiento } from "../../tipoMovimiento"
import { type Categoria } from "../../categoria"
import { type FrecuenciaMovimiento } from "../../frecuenciaMovimiento"
import { type Cuenta } from "../../cuenta"
import { useRoute } from "ziggy-js"
const route= useRoute()

export type MovimientoFijo={
    id : number,
    nombre: string,
    cuenta_id : number,
    tipo_movimiento_id : number,
    categoria_id?: number,
    monto: number,
    fecha_proximo : string,
    frecuencia_movimiento_id: string,
    dias_aviso: number,
    descripcion: string,
    active: boolean,
    registrar_automatico: boolean

}
export type MovimientoFijoTableData = Omit<MovimientoFijo,'tipo_movimiento_id' | 'categoria_id' | 'frecuencia_movimiento_id'>&{
    tipo_movimiento: string,
    categoria: string,
    frecuencia_movimiento: string,
    movimientos?: boolean
}
export const MovimientoFijoActions = {
    post : route('movimientosFijos.store'),
    put : (id: number) => route('movimientosFijos.update', {id}),
    delete : (id: number) => route('movimientosFijos.destroy', {movimientoFijo:id}),
    patch : (id: number) => route('movimientosFijos.update', {id}),
    toggle : (id: number, attribute: keyof typeof MovimientoFijoToggleTypes) => route('movimientosFijos.toggle', {movimientoFijo:id, attribute}),
}as const
export const MovimientoFijoToggleTypes = {
    active: 'active',
    registrar_automatico: 'registrar_automatico'
} as const

export const MovimientoFijoRoutes = {
    index : () => route('movimientosFijos.index'),
    create : () => route('movimientosFijos.create'),
    show : (id: number) => route('movimientosFijos.show', {id}),
    edit : (id: number) => route('movimientosFijos.edit', {id})
}

export type MovimientoFijoFormData = Omit<MovimientoFijo,'id' | 'active' | 'registrar_automatico'>

export type MovimientoFijoFormOptions = { // declaramos las opciones seleccionables del formulario
    tipos_movimientos: TipoMovimiento[],
    categorias: Categoria[],
    frecuencias_movimientos: FrecuenciaMovimiento[],
    cuentas: Cuenta[]
}
export type MovimientoFijoFormProps = // declaramos las propiedades del formulario
    FormCommonProps<MovimientoFijoFormData> & {
    options: MovimientoFijoFormOptions
    }