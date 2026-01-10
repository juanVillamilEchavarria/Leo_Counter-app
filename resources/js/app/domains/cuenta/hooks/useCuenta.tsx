import { toastHelper } from "@/app/shared/helpers"
import { useFormNormal } from "@/app/shared/hooks"
import {  type Cuenta, CuentaActions } from "../types/cuenta.types"
import { FormMethods } from "@/app/shared/types/components"

export default function useCuenta(
{
  method = 'post',
  id,
  data
}:{
    method ?: keyof typeof FormMethods,
    id ?: number | null
    data ?: Cuenta
}) {
    //definimos la action dependiendo del metodo, se encuentra en CuentaActions, puede ser funcion para los metodos de put, patch y delete y una string para el metodo post
    const action =
    typeof CuentaActions[method] === 'function' //aqui se verifica si la accion es una funcion
      ?  (id ? (CuentaActions[method] as any)(id) : null)
      : CuentaActions[method]
    const { form, handleSubmit, submit } = useFormNormal<Cuenta>({
        action,
        data: data ?? {} as Cuenta,
        method
    })
  return {
    form,
    submit,
    handleSubmit
  }
}