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
import { type MovimientoFijo, MovimientoFijoActions, MovimientoFijoRoutes } from "../types/movimientoFijo.types"
export default function useMovimientoFijo({
    method = 'post',
    id,
    data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: MovimientoFijo
}) {
    const action = (() => {
                const current = MovimientoFijoActions[method]
                    if (typeof current === 'function') {
                      return id ? current(id) : ''
                    }
                    return current
            })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
             
         const { form, handleSubmit, submit } = useFormNormal<MovimientoFijo>({
             action,
             data: data ?? {} as MovimientoFijo,
             method
         })
  return {
    form,
    submit,
    handleSubmit
  }
}
