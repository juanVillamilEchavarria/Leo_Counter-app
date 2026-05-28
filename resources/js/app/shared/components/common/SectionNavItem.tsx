import { Link } from "@inertiajs/react"
import { type NavItemProps } from "@/app/shared/types/components"
import { isRouteActive } from "@/app/shared/helpers"
import SectionNavItemGroup from "./SectionNavItemGroup"

export const SectionNavItemBaseStyle = `flex shrink-0 items-center gap-2 p-4 text-foreground border-b border-transparent whitespace-nowrap`
export const SectionNavItemHoverStyle = `hover:text-gray-400  hover:border-gray-400 transition-all`
export const SectionNavItemActiveStyle = `text-cyan-600! border-cyan-600!`
interface SectionNavItemProps extends Pick<NavItemProps, 'icon' | 'routeName' | 'title' | 'href' | 'childrenNav'> {
}
/**
 * Componente de navegacion para las secciones que tienen navegacion propia dentro de su interfaz
 * @param {string} icon 
 * @param {string} routeName 
 * @param {string} title 
 * @param {string} href
 * @returns  {JSX.Element}
 */
export default function SectionNavItem({
     icon = '',
    routeName='',
    title = '',
    href = '#',
    childrenNav = []
}: SectionNavItemProps) {
  return childrenNav.length<=0 ? (
     <Link 
     className={`
        ${SectionNavItemBaseStyle}
        ${isRouteActive(routeName) 
            ? SectionNavItemActiveStyle 
            : SectionNavItemHoverStyle}
        `}
      href={href}>
            <i className={icon}></i>
            <span>{title}</span>
    </Link>
  ):(
    <SectionNavItemGroup
    icon={icon}
    title={title}
    childrenNav={childrenNav}
    />
  )
}
