import { useFormNormal } from "@/app/shared/hooks"
import { FormMethods } from "@/app/shared/types/components"
import { type PresupuestoPorPeriodo, PresupuestoPorPeriodoActions } from "../types/presupuestoPorPeriodo.types"

export default function usePresupuestoPorPeriodo({
    method = 'post',
    id,
    data
}: {
    method?: keyof typeof FormMethods,
    id?: number | null
    data?: PresupuestoPorPeriodo
}) {
    const action = (() => {
        const current = PresupuestoPorPeriodoActions[method]
        if (typeof current === 'function') {
            return id ? current(id) : ''
        }
        return current
    })()

    const { form, handleSubmit, submit } = useFormNormal<PresupuestoPorPeriodo>({
        action,
        data: data ?? {} as PresupuestoPorPeriodo,
        method
    })

    return {
        form,
        submit,
        handleSubmit
    }
}
