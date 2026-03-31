import { myRoute } from "@/app/shared/utilities/utilities";
import { type NavItemConfig } from "@/app/shared/types/components";
import { type User } from "../../user";
export const ProfileRoutes = {
    index: myRoute('profile.index'),
    password: myRoute('profile.password.index'),
} as const

export const ProfileActions={
    profileUpdate : myRoute('profile.update'),
    passwordUpdate : myRoute('profile.password.update')
} as const

/**
 * @interface ProfileUserData - Interfaz que representa los datos del usuario para el perfil, extiende de User pero solo con los campos necesarios para el perfil de actualizacion, como el name, email y id
 */
export interface ProfileUserData extends Pick<User, 'name' | 'email' | 'id'>{}
/**
 * @interface PasswordProfileUserData - Interfaz que representa los datos del usuario para el cambio de contraseña, con los campos necesarios para el cambio de contraseña, como current_password, password y password_confirmation
 */
export interface PasswordProfileUserData {
    current_password: string,
    password: string,
    password_confirmation: string,
}
export const ProfileNavItems : NavItemConfig[]=[
    {
        key: 'profile',
        icon: 'fa-solid fa-user',
        title: 'Mi Perfil',
        href: ProfileRoutes.index,
        routeName: 'profile.index',
    },
    {
        key: 'password',
        icon: 'fa-solid fa-fingerprint',
        title: 'Mi Contraseña',
        href: ProfileRoutes.password,
        routeName: 'profile.password.index',
    },
]