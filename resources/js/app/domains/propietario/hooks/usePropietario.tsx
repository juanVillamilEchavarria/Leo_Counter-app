import { useFormNormal } from "@/app/shared/hooks"
import { FormMethods } from "@/app/shared/types/components"
import { type Propietario, PropietarioActions } from "../types/propietario.types"
export default function usePropietario({
  method = 'post',
  id,
  data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: Propietario
}) {
      const action = (() => {
            const current = PropietarioActions[method]
                if (typeof current === 'function') {
                    return id ? current(id) : ''
                }
                return current
    })()
    
    const { form, handleSubmit, submit } = useFormNormal<Propietario>({
            action,
            data: data ?? {} as Propietario,
            method
        })
  return {
    form,
    submit,
    handleSubmit
  }
}
