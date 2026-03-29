import { myRoute } from "@/app/shared/utilities/utilities";
import { type NavItemConfig } from "@/app/shared/types/components";
export const ProfileRoutes = {
    index: myRoute('profile.index'),
    password: myRoute('profile.password.index'),
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