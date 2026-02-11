import { useFormNormal } from "@/app/shared/hooks"
import { MovimientoEspontaneoActions, type MovimientoEspontaneo } from "../types/movimientoEspontaneo.types"
import { FormMethods } from "@/app/shared/types/components"

export default function useMovimientoEspontaneo({
    method = 'post',
    id,
    data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: MovimientoEspontaneo
}) {
  const action = (() => {
                  const current = MovimientoEspontaneoActions[method]
                      if (typeof current === 'function') {
                        return id ? current(id) : ''
                      }
                      return current
              })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
               
           const { form, handleSubmit, submit } = useFormNormal<MovimientoEspontaneo>({
               action,
               data: data ?? {} as MovimientoEspontaneo,
               method
           })
    return {
      form,
      submit,
      handleSubmit
    }
}
