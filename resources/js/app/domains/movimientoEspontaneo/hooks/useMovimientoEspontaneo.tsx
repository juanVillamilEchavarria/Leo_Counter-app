/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useFormNormal } from "@/app/shared/hooks"
import { MovimientoEspontaneoActions, type MovimientoEspontaneoFormData } from "../types/movimientoEspontaneo.types"
import { FormMethods } from "@/app/shared/types/components"

export default function useMovimientoEspontaneo({
    method = 'post',
    id,
    data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?:  MovimientoEspontaneoFormData
}) {
  const action = (() => {
                  const current = MovimientoEspontaneoActions[method]
                      if (typeof current === 'function') {
                        return id ? current(id) : ''
                      }
                      return current
              })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
               
           const { form, handleSubmit, submit } = useFormNormal< MovimientoEspontaneoFormData>({
               action,
               data: data ?? {} as MovimientoEspontaneoFormData,
               method
           })
    return {
      form,
      submit,
      handleSubmit
    }
}
