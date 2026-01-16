import { useFormNormal } from "@/app/shared/hooks"
import { toastHelper } from "@/app/shared/helpers"
import {  type Categoria, CategoriaActions } from "../types/categoria.types"
import { FormMethods } from "@/app/shared/types/components"
export default function useCategoria({
  method = 'post',
  id,
  data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: Categoria
}) {
        const action = (() => {
            const current = CategoriaActions[method]
                if (typeof current === 'function') {
                  return id ? current(id) : ''
                }
                return current
        })() // es una funcion que se llama inmediatamente para obtener la accion correcta segun el metodo y el id
         
       const { form, handleSubmit, submit } = useFormNormal<Categoria>({
           action,
           data: data ?? {} as Categoria,
           method
       })
      return {
        form,
        submit,
        handleSubmit
      }
}
