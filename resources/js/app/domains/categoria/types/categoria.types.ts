import {type TipoMovimiento } from "../../tipoMovimiento"
import { type FormCommonProps } from "@/app/shared/types/components"
import { useRoute } from "ziggy-js"
const route= useRoute()
export type Categoria={
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
    patch : (id: number) => route('categorias.es-fijo', {id}),
    delete : (id: number) => route('categorias.destroy', {categoria:id})
}as const


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