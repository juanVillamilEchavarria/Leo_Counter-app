/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import {type TipoMovimiento } from "../../tipoMovimiento"
import { type FormCommonProps } from "@/app/shared/types/components"
import { useRoute } from "ziggy-js"
import { type SoftDeleteModel } from "@/app/shared/types"
const route= useRoute()
export interface Categoria extends SoftDeleteModel {
    id: number,
    nombre: string,
    tipo_movimiento_id: number,
    descripcion: string,
    es_fijo: boolean,
    is_system: boolean
}
export type CategoriaTableData = Omit<Categoria, 'tipo_movimiento_id'> & {
    tipo: string
}

export const CategoriaActions = {
    post : route('categorias.store'),
    put : (id: number) => route('categorias.update', {id}),
    patch : (id: number) => route('categorias.update', {id}),
    delete : (id: number) => route('categorias.destroy', {categoria:id}),
    toggle : (id: number, attribute: keyof typeof CategoriaToggleTypes) => route('categorias.toggle', {categoria:id, attribute}),
}as const
export const CategoriaToggleTypes = {
    es_fijo: 'es_fijo'
} as const


export const CategoriaRoutes = {
    index : () => route('categorias.index'),
    create : () => route('categorias.create'),
    show : (id: number) => route('categorias.show', {id}),
    edit : (id: number) => route('categorias.edit', {id})
}

export type CategoriaFormData = Pick< //traemos las propiedades de Categoria que se enviaran al backend mediante el formulario
    Categoria,
    'nombre' | 'tipo_movimiento_id' | 'descripcion' | 'es_fijo'
>

export type CategoriaFormOptions = { // declaramos las opciones seleccionables del formulario
    tipos: TipoMovimiento[]
}

export type CategoriaFormProps = // declaramos las propiedades del formulario
    FormCommonProps<CategoriaFormData> & {
        options: CategoriaFormOptions
    }