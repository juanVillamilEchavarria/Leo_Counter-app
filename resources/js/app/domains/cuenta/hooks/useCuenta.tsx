import { useFormNormal } from "@/app/shared/hooks"
import { type CuentaFormData, type Cuenta, CuentaActions } from "../types/cuenta.types"
import { FormMethods } from "@/app/shared/types/components"
export default function useCuenta(
{
  method = 'post',
  id
}:{
    method ?: keyof typeof FormMethods,
    id ?: number
}) {

    //definimos la action dependiendo del metodo, se encuentra en CuentaActions, puede ser funcion para los metodos de put, patch y delete y una string para el metodo post
    const action =
    typeof CuentaActions[method] === 'function' //aqui se verifica si la accion es una funcion
      ? (CuentaActions[method] as any)(id)
      : CuentaActions[method]

    const { form, handleSubmit } = useFormNormal<Cuenta>({
        action,
        data: {} as Cuenta,
        method
    })
  return {
    form,
    handleSubmit
  }
}