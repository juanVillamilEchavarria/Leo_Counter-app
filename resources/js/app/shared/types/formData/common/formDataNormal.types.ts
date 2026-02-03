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

export type FileWithPreview = File & { preview : string }