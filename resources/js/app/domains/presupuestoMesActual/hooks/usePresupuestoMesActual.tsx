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
import { type Presupuesto, PresupuestoMesActualActions } from "../types/presupuestoMesActual.types"
export default function usePresupuestoMesActual({
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
