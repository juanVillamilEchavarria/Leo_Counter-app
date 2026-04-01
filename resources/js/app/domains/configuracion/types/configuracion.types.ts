import { type NavItemConfig } from "@/app/shared/types/components";
import { myRoute } from "@/app/shared/utilities/utilities";
type SoftDeletedDomainsNames= 'cuentas'| 'categorias'
export const ConfiguracionRoutes={
    index: myRoute('configuracion.index'),
    deleted :(domain : SoftDeletedDomainsNames)=>myRoute('configuracion.deleted.index',{domain})
}
/**
 * items de navegacion de la seccion de configuracion
 */
export const ConfiguracionNavItems: NavItemConfig[] = [
    {
        key: 'General',
        title: 'General',
        icon: 'fa-solid fa-gear fa-lg',
        routeName: 'configuracion.index',
        href: ConfiguracionRoutes.index,
    },
    {
        key: 'Archivados',
        title: 'Archivados/Eliminados',
        icon: 'fa-solid fa-box-archive fa-lg',
        routeName: 'archivados.*',
        childrenNav:[
            {
                key: 'cuentas',
                title: 'Cuentas',
                icon: 'fa-solid fa-wallet fa-lg',
                routeName: 'archivados.cuentas.*',
                href: ConfiguracionRoutes.deleted('cuentas'),
            },
            {
                key:'movimientosPendientes',
                title: 'Movimientos Pendientes',
                icon: 'fa-solid fa-money-bill-transfer fa-lg',
                routeName: '',
                href: '#',
            },
            {
                key: 'Categorias',
                title: 'Categorias',
                icon: 'fa-solid fa-diagram-project fa-lg',
                routeName: '',
                href: '#',
            },
            {
                key: 'Presupuestos',
                title: 'Presupuestos',
                icon: 'fa-solid fa-chart-pie fa-lg',
                routeName: '',
                href: '#',
            },
        ]
            
    }
]