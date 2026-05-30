/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { Link } from "@inertiajs/react"
import TransitionMotion from "../transitions/TransitionMotion"
import Title from "../common/Title"
import NavItemGroup from "./NavItemGroup"
import { useRoute } from "ziggy-js"
import { isRouteActive } from "../../helpers"
import { NavItemCurrentStyles, NavItemHoverStyles, NavItemStyles, NavItemTransitionStyle } from "../../types/components/common/nav.types"
import { type NavItemProps } from "../../types/components/common/nav.types"
export default function NavItem({
    icon = '',
    routeName='',
    isOpen = false,
    title = '',
    childrenNav = [],
    href = '#',
    className = ''
}: NavItemProps
) {
    // si no tiene children devuelve el link normal
  return childrenNav.length <= 0 ? (
     <li className={`flex w-full ${className}`}>
        <Link 
        href={href} 
        className={`
        ${NavItemStyles} 
        ${isRouteActive(routeName)? 
          NavItemCurrentStyles 
          : NavItemHoverStyles  }
        `}>
        {/* se le pasa un icon de fontawesome */}
                <i 
                className={`${icon} ml-2 text-foreground text-2xl ${NavItemTransitionStyle}`}>
                </i>
                <TransitionMotion   initial={{opacity: 0, x: -40}} active={isOpen}>
                    <Title size="md" title={title} className="whitespace-nowrap" />
                </TransitionMotion>
        </Link>
    </li>
  ):(
    // si tiene children se devuelve un desplegable con los links de los children
    <NavItemGroup
      CurrentStyles={NavItemCurrentStyles}
      routeName={routeName}
      ItemStyles={NavItemStyles}
      ItemHoverStyles={NavItemHoverStyles} 
      TransitionStyle={NavItemTransitionStyle}
      isOpen={isOpen} 
      icon={icon} 
      title={title} 
      childrenNav={childrenNav}
     />
  )
}
