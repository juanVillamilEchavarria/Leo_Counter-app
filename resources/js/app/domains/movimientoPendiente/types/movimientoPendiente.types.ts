import { useRoute } from "ziggy-js"
import { type FormCommonProps } from "@/app/shared/types/components"
const route= useRoute()

export const MovimientoPendienteRoutes={
    index : route('movimientos-pendientes.index'),
    create : route('movimientos-pendientes.create'),
    edit : (id: number) => route('movimientos-pendientes.edit', {id}),
    show : (id: number) => route('movimientos-pendientes.show', {id})
}

export const MovimientoPendienteActions= {
    post : route('movimientos-pendientes.store'),
    put : (id: number) => route('movimientos-pendientes.update', {id}),
    delete : (id: number) => route('movimientos-pendientes.destroy', {id})
}

export type MovimientoPendiente = {
    id: number
    nombre : string
    cuenta_id : number
    tipo_movimiento_id : number
    categoria_id : number
    movimiento_fijo_id : number
    fecha_vencimiento : string
    estado : 'pendiente' | 'pagado' | 'vencido'
    url_pago ?: string
    monto : number
    descripcion ?: string
}

export type MovimientoPendienteTableData = Omit< MovimientoPendiente, 'cuenta_id' | 'tipo_movimiento_id' | 'categoria_id' | 'movimiento_fijo_id'> & {
    cuenta : string
    tipo_movimiento : string
    categoria : string
    movimiento_fijo : string
}
