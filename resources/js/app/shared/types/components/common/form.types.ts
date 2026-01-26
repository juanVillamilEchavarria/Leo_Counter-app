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
type FormFillableItem={
    name : string,
    value : string | number | undefined
    id: string
    onChange : ( e : React.ChangeEvent<HTMLInputElement>)=>void
    className ?: string
    placeholder ?: string
    disabled ?: boolean
    required ?: boolean
}
export type InputFillableProps = FormFillableItem & {
    icon? : string
    type? : string
    min? : number | string
    max? : number | string
}
export type TextAreaProps=Omit<InputFillableProps,'type' | 'onChange'> &{
    onChange : ( e : React.ChangeEvent<HTMLTextAreaElement>)=>void
}
export type SelectModelProps <T extends Record<string, any>> =  Omit<FormFillableItem, 'onChange'> & {
    onChange : ( e : React.ChangeEvent<HTMLSelectElement>)=>void | undefined | void,
    iterable : T[],
    iterableOutput ?: string
}