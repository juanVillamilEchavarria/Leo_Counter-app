/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SectionNavItem from "@/app/shared/components/common/SectionNavItem"
import { type NavItemConfig } from "../../types/components"

interface SectionNavBarProps {
    navItems : NavItemConfig[]
    className?: string
}
/**
 * Barra de navegacion para las secciones que tienen navegacion propia dentro de su interfaz, usando SectionNavItem como item de navegacion
 * @param {NavItemConfig[]} navItems 
 * @returns {JSX.Element}
 */
export default function SectionNavBar({
    navItems,
    className
}: SectionNavBarProps) {
  return (
    <div className={`w-full lg:w-[80%] mx-auto flex gap-3 overflow-x-auto border-b border-border items-center px-4 lg:px-0 ${className}`}>
           {navItems.map((item) => (
            <SectionNavItem  icon={item.icon} routeName={item.routeName} title={item.title} href={item.href} key={item.key} childrenNav={item.childrenNav}/>
          ))}
        </div>
  )
}
