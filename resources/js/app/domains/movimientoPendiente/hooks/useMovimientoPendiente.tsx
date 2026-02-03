import { useFormNormal } from "@/app/shared/hooks"
import { FormMethods } from "@/app/shared/types/components"
import { type MovimientoPendiente, MovimientoPendienteActions,  MovimientoPendienteRoutes } from "../types/movimientoPendiente.types"

export default function useMovimientoPendiente({
    method = 'post',
    id,
    data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: MovimientoPendiente 
}) {
    const action = (() => {
                const current = MovimientoPendienteActions[method]
                    if (typeof current === 'function') {
                      return id ? current(id) : ''
                    }
                    return current
            })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
         const { form, handleSubmit, submit } = useFormNormal<MovimientoPendiente  >({
             action,
             data: data ?? {} as MovimientoPendiente  ,
             method
         })
  return {
    form,
    submit,
    handleSubmit
  }
}
