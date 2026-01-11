import { useRoute } from "ziggy-js"
import { type FormCommonProps } from "@/app/shared/types/components"
const route= useRoute()

export const PropietarioRoutes={
    index : route('propietarios.index'),
    create : route('propietarios.create'),
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
    id: number,
    nombre: string,
    apellido: string,
    email: string,
    telefono: string
}