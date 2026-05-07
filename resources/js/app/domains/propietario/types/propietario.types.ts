import { useRoute } from "ziggy-js"
import { type FormCommonProps } from "@/app/shared/types/components"
import type { Cuenta } from "../../cuenta"
import { BaseIcons } from "@/app/shared/types"
const route= useRoute()

export const PropietarioRoutes={
    index : () => route('propietarios.index'),
    create :()=> route('propietarios.create'),
    show : (id: number) => route('propietarios.show', {id}),
    edit : (id: number) => route('propietarios.edit', {id})
}
export const PropietarioActions={
    post : route('propietarios.store'),
    put : (id: number) => route('propietarios.update', {id}),
    patch : (id: number) => route('propietarios.update', {id}),
    delete : (id: number) => route('propietarios.destroy', {propietario:id})
}as const
export type Propietario={
    id: string,
    nombre: string,
    apellido: string,
    email: string,
    telefono: string
}

export type PropietarioTableData = Propietario &{
    no_cuentas : number
}
export type PropietarioShowData = PropietarioTableData &{
    cuentas ? : Cuenta[]
}

export const PropietarioIcons ={
    ...BaseIcons,
    apellido: 'fa-solid fa-file-signature',
    email: 'fa-solid fa-envelope',
    telefono: 'fa-solid fa-phone',
    no_cuentas : 'fa-solid fa-wallet'
}
