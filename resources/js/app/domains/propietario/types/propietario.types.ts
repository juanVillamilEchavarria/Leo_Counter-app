/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useRoute } from "ziggy-js"
import { type FormCommonProps } from "@/app/shared/types/components"
import type { Cuenta } from "../../cuenta"
import { BaseIcons } from "@/app/shared/types"
const route= useRoute()

export const PropietarioRoutes={
    index : () => route('propietarios.index'),
    create :()=> route('propietarios.create'),
    show : (id: string) => route('propietarios.show', {id}),
    edit : (id: string) => route('propietarios.edit', {id})
}
export const PropietarioActions={
    post : route('propietarios.store'),
    put : (id: string) => route('propietarios.update', {id}),
    patch : (id: string) => route('propietarios.update', {id}),
    delete : (id: string) => route('propietarios.destroy', {propietario:id})
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
