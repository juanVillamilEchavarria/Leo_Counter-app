import { myRoute } from "@/app/shared/utilities/utilities";
import { type NavItemConfig } from "@/app/shared/types/components";
import { type User } from "../../user";
import { type FormCommonProps } from "@/app/shared/types/components";
/**
 * Archivo de tipos para el módulo de usuario.
 * Define las rutas, acciones, interfaces de datos y configuración de navegación
 * para la gestión de perfiles, contraseñas y administración CRUD de usuarios.
 */

// ─── Perfil (self) ───────────────────────────────────────────────────────────
export const ProfileRoutes = {
    index: myRoute('profile.index'),
} as const
export const ProfileActions = {
    update: myRoute('profile.update'),
} as const

export const PasswordRoutes = {
    index: myRoute('profile.password.index'),
} as const
export const PasswordActions = {
    update: myRoute('profile.password.update'),
} as const


export interface UsuarioData extends Pick<User, 'name' | 'email' | 'id'> {
    isSuscribed: boolean
}

export interface ChangeOwnPasswordData {
    current_password: string,
    password: string,
    password_confirmation: string,
}

export const ProfileNavItems: NavItemConfig[] = [
    {
        key: 'perfil',
        icon: 'fa-solid fa-user',
        title: 'Mi Usuario',
        href: ProfileRoutes.index,
        routeName: 'profile.index',
    },
    {
        key: 'password',
        icon: 'fa-solid fa-fingerprint',
        title: 'Mi Contraseña',
        href: PasswordRoutes.index,
        routeName: 'profile.password.index',
    },
]

// ─── Administración de Usuarios (CRUD) ──────────────────────────────────────

/**
 * Interfaz que representa un usuario en el listado de administración.
 */
export interface Usuario {
    id: string
    name: string
    email: string
    role: string
    isSuscribed?: boolean
}

/**
 * Datos del formulario de creación/edición de usuario.
 */
export type UsuarioFormData = Pick<Usuario, 'name' | 'email'> & {
    password?: string
    password_confirmation?: string
}

/**
 * Datos del formulario de cambio de contraseña de un usuario (administración).
 */
export interface UsuarioChangePasswordData {
    password: string
    password_confirmation: string
}

/**
 * Props de la vista de edición de usuario en administración.
 */
export interface UsuarioEditViewProps {
    data: Usuario
}

/**
 * Rutas de navegación del módulo de administración de usuarios.
 */
export const UsuarioRoutes = {
    index: () => myRoute('usuarios.index'),
    create: () => myRoute('usuarios.create'),
    edit: (id: string) => myRoute('usuarios.edit', { usuario: id }),
} as const

/**
 * Acciones (endpoints) del módulo de administración de usuarios.
 */
export const UsuarioActions = {
    post: myRoute('usuarios.store'),
    put: (id: string) => myRoute('usuarios.update', { usuario: id }),
    delete: (id: string) => myRoute('usuarios.destroy', { usuario: id }),
    changePassword: (id: string) => myRoute('usuarios.changePassword', { usuario: id }),
} as const

/**
 * Props del formulario de usuario para administración.
 * Extiende FormCommonProps con la data de UsuarioFormData y añade props condicionales.
 */
export type UsuarioAdminFormProps = FormCommonProps<UsuarioFormData> & {
    /** Indica si el usuario tiene suscripción activa (deshabilita campo email en edición) */
    isSuscribed?: boolean
    /** Indica si el formulario es de creación (muestra campos de contraseña) */
    isCreate?: boolean
}

/**
 * Props del formulario de cambio de contraseña de usuario en administración.
 */
export type UsuarioChangePasswordFormProps = FormCommonProps<UsuarioChangePasswordData>
