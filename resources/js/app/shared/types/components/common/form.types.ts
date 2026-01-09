import type { SetDataAction } from "@inertiajs/react"

export const FormMethods= {
    post : 'post',
    put : 'put',
    patch : 'patch',
    delete : 'delete'
}
export type FormCommonProps<TData extends Record<string,any>>={
     data: TData | undefined,
    setData: SetDataAction<TData>,
    errors: Record<string, string>,
    submit: (e: React.FormEvent<HTMLFormElement>) => void,
    processing: boolean
}
export type InputFillableProps = {
    placeholder? : string
    icon? : string
    type? : string
    name? : string
    id? : string
    value? : string | number
    onChange? : any
    className? : string
    disabled? : boolean
    required? : boolean
}
export type TextAreaProps=Omit<InputFillableProps,'type'>