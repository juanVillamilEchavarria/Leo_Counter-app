/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { FormMethods } from "../../components"
export type FormDataNormalProps<TData extends Record<string,any>>={
    action : string,
    method ?: keyof typeof FormMethods
    data ?: TData
}

export type CreateAndEditViewWithOptionsProps<TData extends Record<string,any>, TOptions extends Record<string,any>>={
    data ?: TData
    options : TOptions
}

export type FileWithPreview = {
    file?: File
    preview: string,
    id?: number,
    name?: string,
    nombre?: string
}