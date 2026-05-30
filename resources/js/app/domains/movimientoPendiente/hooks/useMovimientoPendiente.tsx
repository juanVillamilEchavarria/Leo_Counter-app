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
