/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useRoute } from "ziggy-js"
import { type Propietario } from "../../propietario"
import { type FormCommonProps } from "@/app/shared/types/components"
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types"
import { type SoftDeleteModel } from "@/app/shared/types"
const route= useRoute()

export const CuentaRoutes = {
  index : () => route('cuentas.index'),
  create : () => route('cuentas.create'),
  show : (id: string) => route('cuentas.show', {id}),
  edit : (id: string) => route('cuentas.edit', {id})
}
export const CuentaActions = {
  post : route('cuentas.store'),
  put : (id: string) => route('cuentas.update', {id}),
  patch : (id: string) => route('cuentas.update', {id}),
  delete : (id: string) => route('cuentas.destroy', {cuenta:id}),
  toggle : (id: string, attribute: keyof typeof CuentaToggleTypes) => route('cuentas.toggle', {cuenta:id, attribute}),
}as const
export const CuentaToggleTypes = {
  active: 'active'
} as const
export interface Cuenta extends SoftDeleteModel {
  id: string
  nombre: string
  saldo_inicial: number
  saldo_actual: number
  tipo_cuenta_id: number,
  propietario_id: string
  notas: string
  active: boolean
}

type TipoCuenta={
  id: number
  tipo_cuenta: string
}

export type CuentaFormData = Pick< //traemos las propiedades de Cuenta que se enviaran al backend mediante el formulario
  Cuenta,
  'nombre' | 'saldo_inicial' | 'tipo_cuenta_id' | 'propietario_id' | 'notas'
>

export type CuentaFormOptions = { // declaramos las opciones seleccionables del formulario
  tipo_cuentas: TipoCuenta[]
  propietarios: Propietario[]
}
export type CuentaFormProps = // declaramos las propiedades del formulario
  FormCommonProps<CuentaFormData> & {
    options: CuentaFormOptions,
    can_update_saldo ?: boolean
  }

  export type CuentaEditViewProps = CreateAndEditViewWithOptionsProps<Cuenta, CuentaFormOptions> &{
    can_update_saldo : boolean
  }

