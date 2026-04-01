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
    <div className={`w-[80%] mx-auto flex gap-3 border-b border-border items-center ${className}`}>
           {navItems.map((item) => (
            <SectionNavItem  icon={item.icon} routeName={item.routeName} title={item.title} href={item.href} key={item.key} childrenNav={item.childrenNav}/>
          ))}
        </div>
  )
}
