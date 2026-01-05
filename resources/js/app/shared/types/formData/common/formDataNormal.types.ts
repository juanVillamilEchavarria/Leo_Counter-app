
export type FormDataNormalProps<TData extends Record<string,any>, TActions extends string>={
    action : TActions,
    data ?: TData | null | undefined
}