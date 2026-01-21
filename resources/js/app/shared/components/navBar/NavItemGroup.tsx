import TransitionMotion from "../transitions/TransitionMotion"
import Title from "../common/Title"
import NavItem from "./NavItem"
import useOpen from "../../hooks/open/useOpen"
import { useEffect } from "react"
import { type NavItemProps } from "../../types/components"
export default function NavItemGroup({
    icon = '',
    title = '',
    ItemStyles = '',
    ItemHoverStyles = '',
    TransitionStyle= '',
    CurrentStyles='',
    childrenNav = [],
    isOpen = false,
}: NavItemProps) {
        const {isOpen : isOpenChild, setIsOpen: setIsOpenChild} = useOpen(false)
            useEffect(() => {
                if(isOpen === false) setIsOpenChild(false)
            }, [isOpen])
  return (
     <li className={`flex flex-col w-full`}>
            <div className={``}>
                {/* ya no es un link sino un button que despliega los children */}
               <button 
                className={`
                flex items-center gap-3 cursor-pointer w-full ${ItemStyles} ${ItemHoverStyles} `}
                // aca se hace el toggle
                onClick={() => setIsOpenChild(prev => !prev)}
                // si el sideBar esta cerrado se deshabilita
                disabled={isOpen===false}
               > 
                  {/* este es el icono que se le pasa del padre, el correspondiente al grupo */}
                    <i 
                    className={`${icon} ml-2 text-2xl ${TransitionStyle}`}>
                    </i>
                    <TransitionMotion initial={{opacity: 0, x: -40}} active={isOpen} className="w-full">
                        <div className="flex items-center w-full">
                            <Title size="md" title={title} className="whitespace-nowrap" />
                        
                        {/* este es el icono de la flecha */}
                        <i className={`fa-solid fa-chevron-down ml-auto mr-2 text-2xl ${isOpenChild ? 'rotate-180' : ''} ${TransitionStyle}`}></i>
                         
    
                        </div>
                        
                    </TransitionMotion>
                </button>
            </div> 
            {/* aca se muestran los children */}
              
           
             <TransitionMotion transition={{duration:0.15}} initial={{y: -30, opacity: 0}} exit={{x:0, y:-30, opacity:0}} active={isOpenChild} >
                    {/* devuelve una lista de items */}
                <ul className="flex flex-col ml-4">
                    {childrenNav.map(item => (
                    <NavItem
                        {...item}
                        isOpen={isOpenChild}
                        key={item.key}
                    />
                    ))}
                </ul>
            </TransitionMotion>
            
             
            
        </li>
  )
}
