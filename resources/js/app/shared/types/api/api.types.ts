/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { FormMethods } from "../components"
export const ApiMethods ={
    ...FormMethods,
    get : 'get'

} as const

export type ApiParams<TData extends Record<string,any>> = {
        method: keyof typeof ApiMethods,
        url: string,
        data?: TData,
        params?: Record<string, any>
}
export interface ApiValidationError {
  [key: string]: string[];
}

/**
 * formato estandard de error de la API
 */
export interface ApiErrorResponse {
  message: string;
  errors?: ApiValidationError;
}