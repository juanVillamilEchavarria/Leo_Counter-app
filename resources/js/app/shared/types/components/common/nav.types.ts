import { useRoute } from "ziggy-js"
const route = useRoute()
export const NavItemCurrentStyles = 'bg-gray-100 dark:bg-cyan-500/20'
export const NavItemStyles = `
        flex 
        px-3
        h-15
        justify-start
        gap-3
        items-center
        w-full 
        rounded-2xl
        rounded-l-none
        transition-colors
        transition-transform
        ease-in-out 
        duration-400 
        text-gray-900 
    `;
export const NavItemHoverStyles = `
        hover:bg-gray-100

        dark:hover:bg-cyan-900/20
    `
export const NavItemTransitionStyle = 'transition-all duration-300 ease-in-out'
export type NavItemConfig = {
    key: string,
    icon: string,
    title: string,
    routeName?: string | string[],
    href?: string,
    roles?: string[],
    childrenNav?: NavItemConfig[]
}

export const NavItems: NavItemConfig[] = [
    {
        key: 'home',
        title: 'Home',
        icon: 'fa-solid fa-house fa-lg',
        routeName: 'home',
        href: route('home'),
    },
    {
        key: 'cuentas',
        title: 'Cuentas',
        icon: 'fa-solid fa-wallet fa-lg',
        routeName: 'cuentas.*',
        href: route('cuentas.index'),
    },
    {
        key: 'propietarios',
        title: 'Propietarios',
        icon: 'fa-solid fa-users fa-lg',
        routeName: 'propietarios.*',
        href: route('propietarios.index'),
    },
    {
        key: 'movimientos',
        title: 'Movimientos',
        icon: 'fa-solid fa-money-bill-transfer fa-lg',
        routeName: [
            'movimientos.*',
            'movimientosFijos.*',
            'movimientosPendientes.*',
            'movimientosEspontaneos.*'
        ],
        childrenNav: [
            {
                key: 'movimientos',
                title: 'Movimientos Historicos',
                icon: 'fa-solid fa-earth-americas fa-lfa-money-bill-transferg',
                routeName: 'movimientos.*',
                href: route('movimientos.index'),
            },
            {
                key: 'movimientosFijos',
                title: 'Movimientos Fijos',
                icon: 'fa-solid fa-diagram-project fa-lg',
                routeName: 'movimientosFijos.*',
                href: route('movimientosFijos.index'),
            },
            {
                key: 'movimientosPendientes',
                title: 'Movimientos Pendientes',
                icon: 'fa-solid fa-hand-holding-dollar fa-lg',
                routeName: 'movimientosPendientes.*',
                href: route('movimientosPendientes.index'),
            },
            {
                key: 'movimientosEspontaneos',
                title: 'Movimientos Espontaneos',
                icon: 'fa-solid fa-person-walking fa-lg',
                routeName: 'movimientosEspontaneos.*',
                href: route('movimientosEspontaneos.index'),
            }
        ],
        href: route('movimientos.index')
    },

    {
        key: 'categorias',
        title: 'Categorias',
        icon: 'fa-solid fa-tag fa-lg',
        routeName: 'categorias.*',
        href: route('categorias.index'),
    },
    {
        key: 'reportes',
        title: 'Reportes',
        icon: 'fa-solid fa-chart-line fa-lg',
        routeName: 'reportes.*',
        href: route('reportes.index'),
    },
    {
        key: 'presupuestos',
        title: 'Presupuestos',
        icon: 'fa-solid fa-piggy-bank fa-lg',
        routeName: [
            'presupuestosHistoricos.*',
            'presupuestosMesActual.*'
        ],
        childrenNav: [
            {
                key: 'presupuestosHistoricos',
                title: 'Presupuestos Historicos',
                icon: 'fa-solid fa-earth-americas fa-lg',
                routeName: 'presupuestosHistoricos.index',
                href: route('presupuestosHistoricos.index'),
            },
            {
                key: 'presupuestosMesActual',
                title: 'Presupuestos Del Mes',
                icon: 'fa-solid fa-calendar-day fa-lg',
                routeName: 'presupuestosMesActual.*',
                href: route('presupuestosMesActual.index'),
            }
        ],
    },
    {
        key: 'historial',
        title: 'Historial',
        icon: 'fa-solid fa-history fa-lg',
        routeName: 'historial.*',
        href: route('historial.index'),
    },
    {
        key: 'configuracion',
        title: 'Configuracion',
        icon: 'fa-solid fa-gear fa-lg',
        routeName: 'configuracion.index',
        href: '#',
    }

]

export type NavItemProps = {
    icon: string,
    routeName?: string | string[]
    isOpen: boolean
    CurrentStyles?: string
    ItemStyles?: string
    ItemHoverStyles?: string
    TransitionStyle?: string
    title: string
    childrenNav?: Array<NavItemConfig>
    href?: string
    className?: string
}