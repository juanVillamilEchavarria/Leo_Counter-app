import { useRoute } from "ziggy-js"
import { type FormCommonProps } from "@/app/shared/types/components"
import { type TipoMovimiento } from "../../tipoMovimiento"
import { type Categoria } from "../../categoria"
import { type Cuenta } from "../../cuenta"
import { type MovimientoFijo } from "../../movimientoFijo"
import { type FileWithPreview } from "@/app/shared/types"

const route= useRoute()

export const MovimientoPendienteRoutes={
    index : ()=>route('movimientosPendientes.index'),
    create :()=> route('movimientosPendientes.create'),
    edit : (id: number) => route('movimientosPendientes.edit', {id}),
    show : (id: number) => route('movimientosPendientes.show', {id})
}

export const MovimientoPendienteActions= {
    post : route('movimientosPendientes.store'),
    put : (id: number) => route('movimientosPendientes.update', {id}),
    patch : (id: number)=> route('movimientosPendientes.update', {id}),
    delete : (id: number) => route('movimientosPendientes.destroy', {id}),
    markAsDone : (id: number) => route('movimientosPendientes.markAsDone', {id})
}

export type MovimientoPendienteEstados= 'pendiente' | 'realizado' | 'vencido'

export type MovimientoPendiente = {
    id: number
    nombre : string
    cuenta_id : number
    tipo_movimiento_id : number
    categoria_id : number
    movimiento_fijo_id : number | null
    fecha_programada : string
    estado : MovimientoPendienteEstados
    dias_aviso: number | null
    url_pago ?: string
    monto : number
    descripcion ?: string
}

export type MarkAsDonePayload = {
    comprobantes :FileWithPreview[] |null 
}

export type MovimientoPendienteTableData = Omit< MovimientoPendiente, 'cuenta_id' | 'tipo_movimiento_id' | 'categoria_id' | 'movimiento_fijo_id'> & {
    cuenta : string
    tipo_movimiento : string
    categoria : string
    movimiento_fijo : string | null
    enough_balance : boolean
}

export type MovimientoPendienteShowData = MovimientoPendienteTableData &{
    automatic   ?: boolean | null
}

export type MovimientoPendienteFormData = Omit<MovimientoPendiente,'id'>

export type MovimientoPendienteFormOptions = { // declaramos las opciones seleccionables del formulario
    tipos_movimientos: TipoMovimiento[],
    categorias: Categoria[],
    cuentas: Cuenta[],
    movimientos_fijos: MovimientoFijo[]
}

export type MovimientoPendienteFormProps = // declaramos las propiedades del formulario
    FormCommonProps<MovimientoPendienteFormData> & {
    options: MovimientoPendienteFormOptions
}
export type UseMarkAsDoneParams = {
    onClose: () => void
    onSubmit: () => void
    itemSelected: MovimientoPendienteTableData | undefined | null
}

