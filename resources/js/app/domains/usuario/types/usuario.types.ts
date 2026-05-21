import { myRoute } from "@/app/shared/utilities/utilities";
import { type NavItemConfig } from "@/app/shared/types/components";
import { type User } from "../../user";

export const UsuarioRoutes = {
    edit: myRoute('usuario.edit'),
    password: myRoute('usuario.password.edit'),
} as const

export const UsuarioActions = {
    updateDatosPublicos: myRoute('usuario.updateDatosPublicos'),
    cambiarPassword: myRoute('usuario.password.cambiar')
} as const

export interface UsuarioData extends Pick<User, 'name' | 'email' | 'id'> {}

export interface UsuarioPasswordData {
    current_password: string,
    password: string,
    password_confirmation: string,
}

export const UsuarioNavItems: NavItemConfig[] = [
    {
        key: 'usuario',
        icon: 'fa-solid fa-user',
        title: 'Mi Usuario',
        href: UsuarioRoutes.edit,
        routeName: 'usuario.edit',
    },
    {
        key: 'password',
        icon: 'fa-solid fa-fingerprint',
        title: 'Mi Contraseña',
        href: UsuarioRoutes.password,
        routeName: 'usuario.password.edit',
    },
]
