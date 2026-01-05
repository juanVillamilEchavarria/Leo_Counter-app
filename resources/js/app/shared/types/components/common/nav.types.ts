import { useRoute } from "ziggy-js"
const route= useRoute()
export type NavItemConfig={
    key: string,
    icon: string,
    tittle: string,
    routeName?: string,
    href?: string,
    roles?: string[],
    childrenNav?: NavItemConfig[]
}

export const NavItems: NavItemConfig[] = [
            {
            key: 'home',
            tittle: 'Home',
            icon: 'fa-solid fa-house fa-lg',
            routeName: 'home',
            href: route('home'),
        },
        {
            key: 'cuentas',
            tittle: 'Cuentas',
            icon: 'fa-solid fa-wallet fa-lg',
            routeName: 'cuentas.index',
            href: route('cuentas.index'),
        },
        {
            key: 'movimientos',
            tittle: 'Movimientos',
            icon: 'fa-solid fa-money-bill-transfer fa-lg',
            routeName: 'movimientos.index',
            childrenNav: [
                {
                    key: 'movimientosHistoricos',
                    tittle: 'Movimientos Historicos',
                    icon: 'fa-solid fa-earth-americas fa-lg',
                    routeName: 'movimientosHistoricos.index',
                    href: route('movimientosHistoricos.index'),
                },
                {
                    key: 'movimientosDelMes',
                    tittle: 'Movimientos Del Mes',
                    icon: 'fa-solid fa-calendar-day fa-lg',
                    routeName: 'movimientosMesActual.index',
                    href: route('movimientosMesActual.index'),
                }
            ],
        },
        {
            key: 'movimientosFijos',
            tittle: 'Movimientos Fijos',
            icon: 'fa-solid fa-diagram-project fa-lg',
            routeName: 'movimientosFijos.index',
            href: route('movimientosFijos.index'),
        },
        {
            key: 'categorias',
            tittle: 'Categorias',
            icon: 'fa-solid fa-tag fa-lg',
            routeName: 'categorias.index',
            href: '#',
        },
        {
            key: 'reportes',
            tittle: 'Reportes',
            icon: 'fa-solid fa-chart-line fa-lg',
            routeName: 'reportes.index',
            href: '#',
        },
        {
            key: 'presupuestos',
            tittle: 'Presupuestos',
            icon: 'fa-solid fa-piggy-bank fa-lg',
            routeName: 'presupuestos.index',
            href: '#',
        },
        {
            key: 'pagosPendientes',
            tittle: 'Pagos Pendientes',
            icon: 'fa-solid fa-hand-holding-dollar fa-lg',
            routeName: 'pagosPendientes.index',
            href: '#',
        },
        {
            key: 'historial',
            tittle: 'Historial',
            icon: 'fa-solid fa-history fa-lg',
            routeName: 'historial.index',
            href: '#',
        },
        {
            key: 'configuracion',
            tittle: 'Configuracion',
            icon: 'fa-solid fa-gear fa-lg',
            routeName: 'configuracion.index',
            href: '#',
        }

]

export type NavItemProps={
    icon : string,
    routeName ?: string
    isOpen : boolean
    tittle : string
    childrenNav ?: Array<NavItemConfig>
    href ?: string
    className ?: string
}