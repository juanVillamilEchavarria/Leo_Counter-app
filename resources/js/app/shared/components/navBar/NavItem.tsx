import { Link } from "@inertiajs/react"
import TransitionMotion from "../transitions/TransitionMotion"
import Title from "../common/Title"
import NavItemGroup from "./NavItemGroup"
import { useRoute } from "ziggy-js"
import useOpen from "../../hooks/open/useOpen"
import { useEffect } from "react"
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
    const route= useRoute()
    const CurrentStyles= 'bg-azul/60 text-blue-400!' 
    const ItemStyles= `
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
    const ItemHoverStyles=  `
        hover:bg-white/20 
        hover:text-white
    `
    const TransitionStyle= 'transition-all duration-300 ease-in-out'

    // si no tiene children devuelve el link normal
  return childrenNav.length <= 0 ? (
     <li className={`flex w-full ${className}`}>
        <Link href={href} className={`${ItemStyles} ${route().current(routeName) ? CurrentStyles :ItemHoverStyles  }`}>
        {/* se le pasa un icon de fontawesome */}
                <i 
                className={`${icon} ml-2 text-2xl ${TransitionStyle}`}>
                </i>
                <TransitionMotion   initial={{opacity: 0, x: -40}} active={isOpen}>
                    <Title size="md" title={title} className="whitespace-nowrap" />
                </TransitionMotion>
        </Link>
    </li>
  ):(
    // si tiene children se devuelve un desplegable con los links de los children
    <NavItemGroup CurrentStyles={CurrentStyles} ItemStyles={ItemStyles} ItemHoverStyles={ItemHoverStyles} TransitionStyle={TransitionStyle} isOpen={isOpen} icon={icon} title={title} childrenNav={childrenNav} />
  )
}
