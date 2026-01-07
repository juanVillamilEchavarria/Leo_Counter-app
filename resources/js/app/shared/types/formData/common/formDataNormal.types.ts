import { FormMethods } from "../../components"
export type FormDataNormalProps<TData extends Record<string,any>>={
    action : string,
    method ?: keyof typeof FormMethods
    data ?: TData
}