import { useRoute } from "ziggy-js"
const route= useRoute()
export const NavItemCurrentStyles= 'bg-azul/50 text-cyan-400!' 
  export  const NavItemStyles= `
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
        text-white
    `;
 export   const NavItemHoverStyles=  `
        hover:bg-white/10 
        hover:text-white
    `
  export  const NavItemTransitionStyle= 'transition-all duration-300 ease-in-out'
export type NavItemConfig={
    key: string,
    icon: string,
    title: string,
    routeName?: string,
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
            routeName: 'cuentas.index',
            href: route('cuentas.index'),
        },
        {
            key: 'movimientos',
            title: 'Movimientos',
            icon: 'fa-solid fa-money-bill-transfer fa-lg',
            routeName: 'movimientos.index',
            childrenNav: [
                {
                    key: 'movimientosHistoricos',
                    title: 'Movimientos Historicos',
                    icon: 'fa-solid fa-earth-americas fa-lg',
                    routeName: 'movimientosHistoricos.index',
                    href: route('movimientosHistoricos.index'),
                },
                {
                    key: 'movimientosDelMes',
                    title: 'Movimientos Del Mes',
                    icon: 'fa-solid fa-calendar-day fa-lg',
                    routeName: 'movimientosMesActual.index',
                    href: route('movimientosMesActual.index'),
                }
            ],
        },
        {
            key: 'movimientosFijos',
            title: 'Movimientos Fijos',
            icon: 'fa-solid fa-diagram-project fa-lg',
            routeName: 'movimientosFijos.index',
            href: route('movimientosFijos.index'),
        },
        {
            key: 'categorias',
            title: 'Categorias',
            icon: 'fa-solid fa-tag fa-lg',
            routeName: 'categorias.index',
            href: route('categorias.index'),
        },
        {
            key: 'reportes',
            title: 'Reportes',
            icon: 'fa-solid fa-chart-line fa-lg',
            routeName: 'reportes.index',
            href: route('reportes.index'),
        },
        {
            key: 'presupuestos',
            title: 'Presupuestos',
            icon: 'fa-solid fa-piggy-bank fa-lg',
            routeName: 'presupuestos.index',
            href: route('presupuestos.index'),
        },
        {
            key: 'pagosPendientes',
            title: 'Pagos Pendientes',
            icon: 'fa-solid fa-hand-holding-dollar fa-lg',
            routeName: 'pagosPendientes.index',
            href: route('pagosPendientes.index'),
        },
        {
            key: 'historial',
            title: 'Historial',
            icon: 'fa-solid fa-history fa-lg',
            routeName: 'historial.index',
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

export type NavItemProps={
    icon : string,
    routeName ?: string
    isOpen : boolean
    CurrentStyles ?: string
    ItemStyles ?: string
    ItemHoverStyles ?: string
    TransitionStyle ?: string
    title : string
    childrenNav ?: Array<NavItemConfig>
    href ?: string
    className ?: string
}