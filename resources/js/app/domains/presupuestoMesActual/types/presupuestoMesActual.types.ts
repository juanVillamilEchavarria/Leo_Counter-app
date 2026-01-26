import { type FormCommonProps } from "@/app/shared/types/components"
import { type Categoria } from "../../categoria"
import { type User } from "../../user"
import { useRoute } from "ziggy-js"
const route= useRoute()

export type Presupuesto ={
    id: number
    user_id: number
    categoria_id: number
    monto: number
    periodo: string
}

export type PresupuestoMesActualTableData = Omit<Presupuesto, 'periodo'> &{
    user: string
    categoria: string
}

export const PresupuestoMesActualActions = {
    post: route('presupuestosMesActual.store'),
    put : (id: number) => route('presupuestosMesActual.update', {id}),
    patch : (id: number) => route('presupuestosMesActual.update', {id}),
    delete : (id: number) => route('presupuestosMesActual.destroy', {id})

}

export const PresupuestoMesActualRoutes={
    index: ()=>route('presupuestosMesActual.index'),
    create: ()=>route('presupuestosMesActual.create'),
    show: (id: number) => route('presupuestosMesActual.show', {id}),
    edit: (id: number) => route('presupuestosMesActual.edit', {id})
} as const

export type PresupuestoMesActualFormOptions={
    users: User[]
    categorias: Categoria[]
}

export type PresupuestoMesActualFormProps = FormCommonProps<Presupuesto> & {
    options: PresupuestoMesActualFormOptions
}
