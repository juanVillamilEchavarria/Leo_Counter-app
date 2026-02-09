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