import TransitionMotion from "../transitions/TransitionMotion"
import Title from "../common/Title"
import NavItem from "./NavItem"
import useOpen from "../../hooks/open/useOpen"
import { useEffect } from "react"
import { type NavItemConfig, type NavItemProps } from "../../types/components"
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
               <button 
               className={`
               flex items-center gap-3 cursor-pointer w-full ${ItemStyles} ${ItemHoverStyles} `}
               onClick={() => setIsOpenChild(prev => !prev)}
               disabled={isOpen===false}
               >
                    <i 
                    className={`${icon} ml-2 text-2xl ${TransitionStyle}`}>
                    </i>
                    <TransitionMotion initial={{opacity: 0, x: -40}} active={isOpen} className="w-full">
                        <div className="flex items-center w-full">
                            <Title size="md" title={title} className="whitespace-nowrap" />
                      
                        <i className={`fa-solid fa-chevron-down ml-auto mr-2 text-2xl ${isOpenChild ? 'rotate-180' : ''} ${TransitionStyle}`}></i>
                         
    
                        </div>
                        
                    </TransitionMotion>
                </button>
            </div>
              
            <div
                className={`
                    ml-3
                    overflow-hidden
                    transition-all
                    duration-300
                    ease-in-out
                    ${isOpenChild ? 'h-full  opacity-100' : 'max-h-0 opacity-0'}
                `}
                >
                <ul className="flex flex-col">
                    {childrenNav.map(item => (
                    <NavItem
                        {...item}
                        isOpen={isOpenChild}
                        key={item.key}
                    />
                    ))}
                </ul>
            </div>
             
            
        </li>
  )
}
