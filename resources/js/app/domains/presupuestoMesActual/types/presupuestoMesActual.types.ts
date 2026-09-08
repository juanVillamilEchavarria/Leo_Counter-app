/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type FormCommonProps } from "@/app/shared/types/components"
import { type Categoria } from "../../categoria"
import { type User } from "../../user"
import { useRoute } from "ziggy-js"
const route= useRoute()

export type Presupuesto ={
    id: string
    user_id: number
    categoria_id: string
    monto: number
    descripcion?: string
    fecha_inicio: string,
    fecha_final: string
}

export type PresupuestoMesActualTableData = Omit<Presupuesto, 'periodo'> &{
    user: string
    categoria: string
    isDuplicate: boolean
}

export const PresupuestoMesActualActions = {
    post: route('presupuestosMesActual.store'),
    put : (id: string) => route('presupuestosMesActual.update', {id}),
    patch : (id: string) => route('presupuestosMesActual.update', {id}),
    delete : (id: string) => route('presupuestosMesActual.destroy', {id}),
    duplicate : (id: string) => route('presupuestosMesActual.duplicate', {id})

}

export const PresupuestoMesActualRoutes={
    index: ()=>route('presupuestosMesActual.index'),
    create: ()=>route('presupuestosMesActual.create'),
    show: (id: string) => route('presupuestosMesActual.show', {id}),
    edit: (id: string) => route('presupuestosMesActual.edit', {id})
} as const

export type PresupuestoMesActualFormOptions={
    categorias: Categoria[]
}

export type PresupuestoMesActualFormProps = FormCommonProps<Presupuesto> & {
    options: PresupuestoMesActualFormOptions
}
