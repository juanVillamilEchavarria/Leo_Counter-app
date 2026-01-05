import { Link } from "@inertiajs/react"
import TransitionMotion from "../transitions/TransitionMotion"
import Tittle from "../Tittle"
import NavItemGroup from "./NavItemGroup"
import { useRoute } from "ziggy-js"
import useOpen from "../../hooks/open/useOpen"
import { useEffect } from "react"
import { type NavItemProps } from "../../types/components/common/nav.types"
export default function NavItem({
    icon = '',
    routeName='',
    isOpen = false,
    tittle = '',
    childrenNav = [],
    href = '#',
    className = ''
}: NavItemProps
) {
    const route= useRoute()
    const CurrentStyles= 'bg-white/80 text-black!' 
    const ItemStyles= `
        flex 
        px-3 
        h-10
        justify-start
        gap-3
        items-center
        w-full 
        rounded-2xl
        transition-all
        ease-in-out 
        duration-300 
        text-white
    `;
    const ItemHoverStyles=  `
        hover:bg-white/80 
        hover:text-black
    `
    const TransitionStyle= 'transition-all duration-300 ease-in-out'

    // si no tiene children devuelve el link normal
  return childrenNav.length <= 0 ? (
     <li className={`flex  h-10 w-full ${className}`}>
        <Link href={href} className={`${ItemStyles} ${ItemHoverStyles} ${route().current(routeName) ? CurrentStyles : ''}`}>
        {/* se le pasa un icon de fontawesome */}
                <i 
                className={`${icon} text-2xl ${TransitionStyle}`}>
                </i>
                <TransitionMotion initial={{opacity: 0, x: -40}} active={isOpen}>
                    <Tittle size="md" tittle={tittle} className="whitespace-nowrap" />
                </TransitionMotion>
        </Link>
    </li>
  ):(
    // si tiene children se devuelve un desplegable con los links de los children
    <NavItemGroup isOpen={isOpen} icon={icon} tittle={tittle} childrenNav={childrenNav} />
  )
}
