import { Link } from "@inertiajs/react"
import { type NavItemConfig } from "@/app/shared/types/components"
import { isRouteActive } from "@/app/shared/helpers"

const ProfileNavigationItemBaseStyle = `flex items-center gap-2 p-4 text-foreground border-b border-transparent`
const ProfileNavigationItemHoverStyle = `hover:text-gray-400  hover:border-gray-400 transition-all`
const ProfileNavigationItemActiveStyle = `text-cyan-600! border-cyan-600!`
/**
 * Componente de navegacion de la interfaz de perfil
 * @param {string} icon 
 * @param {string} routeName 
 * @param {string} title 
 * @param {string} href
 * @returns  {JSX.Element}
 */
export default function ProfileNavigationItem({
     icon = '',
    routeName='',
    title = '',
    href = '#',
}: NavItemConfig) {
  return (
     <Link 
     className={`
        ${ProfileNavigationItemBaseStyle}
        ${isRouteActive(routeName) 
            ? ProfileNavigationItemActiveStyle 
            : ProfileNavigationItemHoverStyle}
        `}
      href={href}>
            <i className={icon}></i>
            <span>{title}</span>
    </Link>
  )
}
