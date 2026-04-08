import { type NavItemConfig } from "@/app/shared/types/components";
import { myRoute } from "@/app/shared/utilities/utilities";
/**
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
/**
 * Nombres permitidos de los dominios de soft delete en configuracion
 */
export type SoftDeletedDomainsNames= 'cuentas'| 'categorias' | 'movimientosPendientes' | 'presupuestos'
/**
 * Acciones permitidas en la seccion de configuracion
 */
export const ConfiguracionActions ={
    restore : (domain : SoftDeletedDomainsNames,id : number) => myRoute('configuracion.deleted.restore',{domain, id}),
    hardDelete : (domain : SoftDeletedDomainsNames,id : number) => myRoute('configuracion.deleted.hardDelete',{domain, id})
}
/**
 * Rutas permitidas en la seccion de configuracion
 */
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
                routeName: 'archivados.movimientosPendientes.*',
                href: ConfiguracionRoutes.deleted('movimientosPendientes'),
            },
            {
                key: 'Categorias',
                title: 'Categorías',
                icon: 'fa-solid fa-diagram-project fa-lg',
                routeName: 'archivados.categorias.*',
                href: ConfiguracionRoutes.deleted('categorias'),
            },
            {
                key: 'Presupuestos',
                title: 'Presupuestos',
                icon: 'fa-solid fa-chart-pie fa-lg',
                routeName: 'archivados.presupuestos.*',
                href: ConfiguracionRoutes.deleted('presupuestos'),
            },
        ]
            
    }
]