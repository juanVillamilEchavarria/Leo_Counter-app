import { useFormNormal } from "@/app/shared/hooks"
import { FormMethods } from "@/app/shared/types/components"
import { type Presupuesto, PresupuestoMesActualActions } from "../types/presupuestoMesActual.types"
export default function usePresupuesto({
    method = 'post',
    id,
    data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: Presupuesto
}) {
    const action = (() => {
                const current = PresupuestoMesActualActions[method]
                    if (typeof current === 'function') {
                      return id ? current(id) : ''
                    }
                    return current
            })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
             
         const { form, handleSubmit, submit } = useFormNormal<Presupuesto>({
             action,
             data: data ?? {} as Presupuesto,
             method
         })
  return {
    form,
    submit,
    handleSubmit
  }
}
