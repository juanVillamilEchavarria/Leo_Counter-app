import TransitionMotion from "../transitions/TransitionMotion"
import Tittle from "../Tittle"
import NavItem from "./NavItem"
import useOpen from "../../hooks/open/useOpen"
import { useEffect } from "react"
import { type NavItemConfig, type NavItemProps } from "../../types/components"
export default function NavItemGroup({
    icon = '',
    tittle = '',
    childrenNav = [],
    isOpen = false,
}: NavItemProps) {
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
        const {isOpen : isOpenChild, setIsOpen: setIsOpenChild} = useOpen(false)
            useEffect(() => {
                if(isOpen === false) setIsOpenChild(false)
            }, [isOpen])
  return (
     <li className="flex flex-col w-full">
            <div className={`${ItemStyles} ${ItemHoverStyles}`}>
               <button 
               className=" 
               flex items-center gap-3 h-10 cursor-pointer w-full"
               onClick={() => setIsOpenChild(prev => !prev)}
               disabled={isOpen===false}
               >
                    <i 
                    className={`${icon} text-2xl ${TransitionStyle}`}>
                    </i>
                    <TransitionMotion initial={{opacity: 0, x: -40}} active={isOpen} className="w-full">
                        <div className="flex items-center w-full">
                            <Tittle size="md" tittle={tittle} className="whitespace-nowrap" />
                      
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
                    ${isOpenChild ? 'max-h-96 opacity-100 mt-3' : 'max-h-0 opacity-0'}
                `}
                >
                <ul className="flex flex-col gap-2">
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
