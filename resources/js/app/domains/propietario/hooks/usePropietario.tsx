/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useFormNormal } from "@/app/shared/hooks"
import { FormMethods } from "@/app/shared/types/components"
import { type Propietario, PropietarioActions } from "../types/propietario.types"
export default function usePropietario({
  method = 'post',
  id,
  data
}:{
    method ?: keyof typeof FormMethods,
    id ?: string | null
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
