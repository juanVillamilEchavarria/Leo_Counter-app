import { type FormCommonProps } from "@/app/shared/types/components"
import { type Categoria } from "../../categoria"
import { type TipoPresupuesto } from "../../tipoPresupuesto"
import { type User } from "../../user"
import { useRoute } from "ziggy-js"
const route = useRoute()

export type PresupuestoPorPeriodo = {
    id: number
    user_id: number
    categoria_id: number
    tipo_presupuesto_id: number
    monto: number
    fecha_inicio: string
    fecha_final: string
    descripcion?: string | null
}

export type PresupuestoPorPeriodoTableData = Omit<PresupuestoPorPeriodo, 'user_id'> & {
    user: string
    categoria: string
    tipo_presupuesto: string
}

export const PresupuestoPorPeriodoActions = {
    post: route('presupuestosPorPeriodo.store'),
    put: (id: number) => route('presupuestosPorPeriodo.update', { id }),
    patch: (id: number) => route('presupuestosPorPeriodo.update', { id }),
    delete: (id: number) => route('presupuestosPorPeriodo.destroy', { id })
}

export const PresupuestoPorPeriodoRoutes = {
    index: () => route('presupuestosPorPeriodo.index'),
    create: () => route('presupuestosPorPeriodo.create'),
    show: (id: number) => route('presupuestosPorPeriodo.show', { id }),
    edit: (id: number) => route('presupuestosPorPeriodo.edit', { id })
} as const

export type PresupuestoPorPeriodoFormOptions = {
    categorias: Categoria[]
    tipo_presupuestos: TipoPresupuesto[]
}

export type PresupuestoPorPeriodoFormProps = FormCommonProps<PresupuestoPorPeriodo> & {
    options: PresupuestoPorPeriodoFormOptions
}
