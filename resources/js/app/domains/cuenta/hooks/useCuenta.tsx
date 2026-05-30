/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { toastHelper } from "@/app/shared/helpers"
import { useFormNormal } from "@/app/shared/hooks"
import { type Cuenta, CuentaActions } from "../types/cuenta.types"
import { FormMethods } from "@/app/shared/types/components"

export default function useCuenta(
  {
    method = 'post',
    id,
    data
  }: {
    method?: keyof typeof FormMethods,
    id?: number | null
    data?: Cuenta
  }) {
  //definimos la action dependiendo del metodo, se encuentra en CuentaActions, puede ser funcion para los metodos de put, patch y delete y una string para el metodo post
  const action = (() => {
    const current = CuentaActions[method]
    if (typeof current === 'function') {
      return id ? current(id) : ''
    }
    return current
  })()

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