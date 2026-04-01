import { Button } from "../ui/button"
import SectionNavItem from "./SectionNavItem"
import { DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger} 
from "../ui/dropdown-menu"
import { useOpen } from "../../hooks"
import { SectionNavItemActiveStyle, SectionNavItemBaseStyle,SectionNavItemHoverStyle } from "./SectionNavItem"
import { type NavItemProps } from "../../types/components"
interface SectionNavItemGroupProps extends Pick<NavItemProps, 'icon' | 'title'  | 'childrenNav'> {}
/**
 * Grupo/lista desplegable de items de navegacion para las secciones que tienen navegacion propia dentro de su interfaz, usando SectionNavItem como item de navegacion
 * @param {NavItemConfig[]} childrenNav 
 * @returns {JSX.Element}
 */
export default function SectionNavItemGroup({
  icon,
  title,
  childrenNav = [],
}: SectionNavItemGroupProps) {
  const { isOpen, setIsOpen } = useOpen(false)

  return (
    <DropdownMenu open={isOpen} onOpenChange={setIsOpen}>
      <DropdownMenuTrigger asChild>
        <Button
          variant="ghost"
          className={`
            flex items-center gap-2
            h-full!
            ${SectionNavItemBaseStyle}
            ${SectionNavItemHoverStyle}
            ${SectionNavItemActiveStyle}
          `}
        >
          <i className={icon}></i>
          <span>{title}</span>

          <i
            className={`fa-solid fa-chevron-down text-2xl transition-all ${
              isOpen && "rotate-180"
            }`}
          ></i>
        </Button>
      </DropdownMenuTrigger>

      <DropdownMenuContent align="start" className="p-0">
        {childrenNav.map((item) => (
          <DropdownMenuItem key={item.key} className="p-0 m-0" asChild>
            <SectionNavItem key={item.key} icon={item.icon} routeName={item.routeName} title={item.title} href={item.href}/>
          </DropdownMenuItem>
        ))}
      </DropdownMenuContent>
    </DropdownMenu>
  )
}